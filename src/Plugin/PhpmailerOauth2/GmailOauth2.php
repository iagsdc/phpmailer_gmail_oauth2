<?php

namespace Drupal\phpmailer_gmail_oauth2\Plugin\PhpmailerOauth2;

use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\phpmailer_gmail_oauth2\Service\GmailProviderService;
use Drupal\phpmailer_smtp\Plugin\PhpmailerOauth2\PhpmailerOauth2PluginBase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Gmail OAuth2 plugin.
 *
 * @PhpmailerOauth2(
 *   id = "gmail",
 *   name = @Translation("Gmail OAuth2"),
 * )
 */
class GmailOauth2 extends PhpmailerOauth2PluginBase implements ContainerFactoryPluginInterface {

    /**
     * The Gmail provider service.
     *
     * @var \Drupal\phpmailer_gmail_oauth2\Service\GmailProviderService
     */
    protected $gmailProvider;

    /**
     * {@inheritdoc}
     */
    public function __construct(array $configuration, $plugin_id, $plugin_definition, GmailProviderService $gmail_provider) {

        parent::__construct($configuration, $plugin_id, $plugin_definition);
        $this->gmailProvider = $gmail_provider;
    }

    /**
     * {@inheritdoc}
     */
    public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {

        return new static(
            $configuration,
            $plugin_id,
            $plugin_definition,
            $container->get('phpmailer_gmail_oauth2.gmail_provider')
        );
    }

    /**
     * {@inheritdoc}
     */

    public function getAuthOptions() {

        return $this->gmailProvider->getAuthOptions();
    }
}
