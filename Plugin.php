<?php namespace VojtaSvoboda\Fakturoid;

use Backend;
use Config;
use Fakturoid\Client;
use System\Classes\PluginBase;
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
                'order' => 500,
                'sideMenu' => [
                    'logs' => [
                        'label' => 'Fakturoid',
                        'url' => Backend::url('vojtasvoboda/fakturoid/logs'),
                        'icon' => 'icon-cloud-upload',
                        'permissions' => ['vojtasvoboda.fakturoid.logs'],
                        'order' => 500,
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
            'vojtasvoboda.fakturoid.logs' => [
                'tab' => 'Fakturoid',
                'label' => 'Fakturoid logs',
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
                'order' => 500,
                'keywords' => 'fakturoid'
            ]
        ];
    }

    /**
     * Prepare service provider for Fakturoid Client.
     */
    public function register()
    {
        // bind Fakturoid Client to the application
        $this->app->bind(Client::class, function ($app) {
            $account_id = Settings::get('account_id');
            $account_email = Settings::get('account_email');
            $api_key = Settings::get('api_key');

            // resolve application identifier
            $app_ident = Config::get('vojtasvoboda.fakturoid::config.user_agent.name');
            $include_email = Config::get('vojtasvoboda.fakturoid::config.user_agent.include_email', true);
            if ($include_email === true) {
                $app_ident = sprintf('%s (%s)', $app_ident, $account_email);
            }

            return new Client($account_id, $account_email, $api_key, $app_ident);
        });
    }
}
