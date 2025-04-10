<?php namespace VojtaSvoboda\Fakturoid;

use Backend;
use Fakturoid\FakturoidManager;
use GuzzleHttp\HandlerStack;
use Illuminate\Support\Facades\Http;
use System\Classes\PluginBase;
use VojtaSvoboda\Fakturoid\Models\Log;
use VojtaSvoboda\Fakturoid\Models\Settings;

/**
 * Fakturoid Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {
        return [
            'fakturoid' => [
                'label' => 'Fakturoid',
                'url' => Backend::url('vojtasvoboda/fakturoid/logs'),
                'icon' => 'icon-cloud-upload',
                'permissions' => ['vojtasvoboda.fakturoid.logs'],
                'order' => 600,
                'sideMenu' => [
                    'logs' => [
                        'label' => 'Log',
                        'url' => Backend::url('vojtasvoboda/fakturoid/logs'),
                        'icon' => 'icon-cloud-upload',
                        'permissions' => ['vojtasvoboda.fakturoid.logs'],
                        'order' => 500,
                        'counter' => (new Log())->getUnsolvedCount(),
                    ],
                    'webhooklogs' => [
                        'label' => 'Webhook log',
                        'url' => Backend::url('vojtasvoboda/fakturoid/webhooklogs'),
                        'icon' => 'icon-cloud-upload',
                        'permissions' => ['vojtasvoboda.fakturoid.webhooklogs'],
                        'order' => 510,
                    ],
                ],
            ],
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return [
            'vojtasvoboda.fakturoid.settings' => [
                'tab' => 'Fakturoid',
                'label' => 'Fakturoid settings',
            ],
            'vojtasvoboda.fakturoid.logs' => [
                'tab' => 'Fakturoid',
                'label' => 'Fakturoid logs',
            ],
            'vojtasvoboda.fakturoid.webhooklogs' => [
                'tab' => 'Fakturoid',
                'label' => 'Fakturoid webhook logs',
            ],
        ];
    }

    /**
     * Registers back-end settings for this plugin.
     *
     * @return array
     */
    public function registerSettings()
    {
        return [
            'fakturoid' => [
                'category' => 'system::lang.system.categories.system',
                'label' => 'Fakturoid',
                'description' => 'Fakturoid settings.',
                'icon' => 'icon-cloud-upload',
                'class' => Settings::class,
                'permissions' => ['vojtasvoboda.fakturoid.settings'],
                'order' => 500,
                'keywords' => 'fakturoid',
            ]
        ];
    }

    /**
     * Prepare service provider for Fakturoid Manager.
     */
    public function register()
    {
        $this->app->bind(FakturoidManager::class, function ($app) {
            $account_id = Settings::get('account_id');
            $api_client_id = Settings::get('api_client_id');
            $api_client_secret = Settings::get('api_client_secret');

            // prepare PSR-18 client
            $stack = HandlerStack::create();
            $http = Http::createClient($stack);
            $userAgent = 'Fakturoid plugin for OctoberCMS <vojtasvoboda.cz@gmail.com>';

            // create Fakturoid manager
            $manager = new FakturoidManager(
                $http,
                $api_client_id,
                $api_client_secret,
                $userAgent,
                $account_id
            );

            // login using OAuth2 Client Credentials Flow
            $manager->authClientCredentials();

            return $manager;
        });
    }
}
