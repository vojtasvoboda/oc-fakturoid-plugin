<?php namespace VojtaSvoboda\Fakturoid\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Redirect;
use VojtaSvoboda\Fakturoid\Models\Log;

/**
 * @method listRefresh()
 */
class Logs extends Controller
{
    public $implement = [
        \Backend\Behaviors\ListController::class,
    ];

    /**
     * @var string Configuration file for the `ListController` behavior.
     */
    public $listConfig = 'config_list.yaml';

    /**
     * @var array required permissions
     */
    public $requiredPermissions = ['vojtasvoboda.fakturoid.logs'];

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('VojtaSvoboda.Fakturoid', 'fakturoid', 'logs');
    }

    public function listInjectRowClass(Log $log, $definition = null)
    {
        // show solved items grayed out
        if ($log->solved) {
            return 'deleted';
        }
    }

    public function onSetSolved()
    {
        $id = post('id');
        $this->getModelInstance($id)?->setSolved();

        return Redirect::back();
    }

    public function onUnsetSolved()
    {
        $id = post('id');
        $this->getModelInstance($id)?->unsetSolved();

        return Redirect::back();
    }

    protected function getModelInstance(?int $id = null): ?Log
    {
        return Log::find($id);
    }
}
