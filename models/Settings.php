<?php namespace VojtaSvoboda\Fakturoid\Models;

use Model;
use October\Rain\Database\Traits\Validation as ValidationTrait;

class Settings extends Model
{
    use ValidationTrait;

    public $implement = ['System.Behaviors.SettingsModel'];

    public $settingsCode = 'vojtasvoboda_fakturoid_settings';

    public $settingsFields = 'fields.yaml';

    public $rules = [
        'account_id' => 'required',
        'api_client_id' => 'required|size:40',
        'api_client_secret' => 'required|size:40',
    ];
}
