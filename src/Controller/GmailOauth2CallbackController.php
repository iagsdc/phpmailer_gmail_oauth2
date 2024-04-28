<?php

namespace Drupal\phpmailer_gmail_oauth2\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Config\ConfigFactoryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Drupal\Core\Routing\TrustedRedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Drupal\Core\Session\SessionManagerInterface;
use Drupal\phpmailer_gmail_oauth2\Service\GmailProviderService;
use League\OAuth2\Client\Provider\Google;

/**
 * Class GmailOauth2CallbackController
 */
class GmailOauth2CallbackController extends ControllerBase {

    /**
     * The request stack used to access request globals
     *
     * @var \Symfony\Component\HttpFoundation\RequestStack
     */
    protected $requestStack;

    /**
     * The config factory.
     *
     * @var \Drupal\Core\Config\ConfigFactoryInterface
     */
    protected $configFactory;

    /**
     * The Gmail provider service
     *
     * @var \Drupal\phpmailer_gmail_oauth2\Service\GmailProviderService
     */
    protected $gmailProvider;

    /**
     * The current session
     */
    protected $session;

    /**
     * {@inheritdoc}
     */
    public function __construct(RequestStack           $request_stack,
                                ConfigFactoryInterface $config_factory,
                                GmailProviderService   $gmail_provider,) {

        $this->requestStack  = $request_stack;
        $this->configFactory = $config_factory;
        $this->gmailProvider = $gmail_provider;

        $this->session       = $this->requestStack->getCurrentRequest()->getSession();
    }

    /**
     * {@inheritdoc}
     */
    public static function create(ContainerInterface $container) {

        return new static(
            $container->get('request_stack'),
            $container->get('config.factory'),
            $container->get('phpmailer_gmail_oauth2.gmail_provider'),
        );
    }

    /**
     * Callback for the login
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     *   The request
     *
     * @return mixed
     *   A redirect to the settings page
     *
     */
    public function callback(Request $request) {


        if(empty($request->query->get('state')) || ($request->query->get('state') !== $this->session->get('oauth2state'))) {

            $this->messenger()->addError($this->t('Invalid state') . ' ' . $this->session->get('oauth2state'));

        } else {

            $provider = $this->gmailProvider->getProvider();
            $token    = $provider->getAccessToken(
                'authorization_code',
                [
                    'code' => $request->query->get('code')
                ]
            );

            // get a new access token 
            $myToken = $token->getRefreshToken();
            $config  = $this->configFactory->getEditable('phpmailer_gmail_oauth2.gmail_settings');
            $config->set('gm_refresh_access_token', $myToken);
            $config->save();
            $this->messenger()->addMessage('Refresh Token: ' . $myToken);
        }
        $this->session->remove('oauth2state');

        return $this->redirect('phpmailer_gmail_oauth2.gmail_settings');
    }
}
