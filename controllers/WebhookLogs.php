<?php namespace VojtaSvoboda\Fakturoid\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Webhook Logs Backend Controller
 *
 * @link https://docs.octobercms.com/3.x/extend/system/controllers.html
 */
class WebhookLogs extends Controller
{
    public $implement = [
        \Backend\Behaviors\ListController::class,
    ];

    /**
     * @var string listConfig file
     */
    public $listConfig = 'config_list.yaml';

    /**
     * @var array required permissions
     */
    public $requiredPermissions = ['vojtasvoboda.fakturoid.webhooklogs'];

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('VojtaSvoboda.Fakturoid', 'fakturoid', 'webhooklogs');
    }
}
