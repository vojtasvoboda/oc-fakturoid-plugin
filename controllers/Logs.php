<?php namespace VojtaSvoboda\Fakturoid\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Logs Back-end Controller
 */
class Logs extends Controller
{
    /**
     * @var array Behaviors that are implemented by this controller.
     */
    public $implement = [
        'Backend.Behaviors.ListController',
    ];

    /**
     * @var string Configuration file for the `ListController` behavior.
     */
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('VojtaSvoboda.Fakturoid', 'fakturoid', 'logs');
    }
}
