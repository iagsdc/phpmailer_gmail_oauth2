<?php

namespace Drupal\phpmailer_gmail_oauth2\Service;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Url;
use Symfony\Component\HttpFoundation\RequestStack;
use PHPMailer\PHPMailer\OAuth;
use League\OAuth2\Client\Provider\Google;

/**
 * Helper to generate a new Gmail provider.
 */
class GmailProviderService {

    /**
     * Config factory.
     *
     * @var \Drupal\Core\Config\ConfigFactoryInterface
     */
    protected $configFactory;

    /**
    /**
     * The request stack.
     *
     * @var \Symfony\Component\HttpFoundation\RequestStack
     */
    protected $requestStack;

    /**
     * The constructor.
     *
     * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
     *   The config factory.
     * @param \Symfony\Component\HttpFoundation\RequestStack $request_stack
     *   The request stack.
     */
    public function __construct(ConfigFactoryInterface $config_factory, RequestStack $request_stack) {

        $this->configFactory = $config_factory;
        $this->requestStack  = $request_stack;
    }

    /**
     * Create a new provider for SMTP Auth
     *
     * @return object
     *   The Gmail provider
     */
    public function getProvider() {

        \Drupal::logger('GmailProviderService')->notice("getProvider()");
        $config = $this->configFactory->get('phpmailer_gmail_oauth2.gmail_settings');

        $params = [
            'clientId'     => $config->get('gm_client_id'),
            'clientSecret' => $config->get('gm_client_secret'),
            'redirectUri'  => $config->get('gm_provider_url'),
            'accessType'   => 'offline',
            'prompt'       => 'consent',
        ];
        #   'redirectUri'  => Url::fromRoute('phpmailer_gmail_oauth2.gmail_callback')->setAbsolute()->toString(),
        #   'redirectUri'  => 'https://sandbox.iagsdc.org/phpmailer_oauth2/gmail-callback',

        return new Google($params);
    }

    /**
     * Get provider options array
     *
     * @return array
     *   Array of Gmail provider options
     */
    public function getOptions() {

        return [
            'scope' => [
                'https://mail.google.com/'
            ],
        ];
    }

    /**
     * Get OAuth options for PHPMailer OAuth.
     *
     * @return array
     *   PHPMailer auth options
     */
    public function getAuthOptions() {

        \Drupal::logger('GmailProviderService')->notice("getOAuthOptions()");
        $config = $this->configFactory->get('phpmailer_gmail_oauth2.gmail_settings');
        return [
            'provider'     => $this->getProvider(),
            'userName'     => $config->get('gm_email_address'),
            'clientSecret' => $config->get('gm_client_secret'),
            'clientId'     => $config->get('gm_client_id'),
            'refreshToken' => $config->get('gm_refresh_access_token'),
        ];
    }
}
