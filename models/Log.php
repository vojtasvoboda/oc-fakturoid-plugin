<?php namespace VojtaSvoboda\Fakturoid\Models;

use Model;

/**
 * Log Model
 */
class Log extends Model
{
    /**
     * @var string $table The database table used by the model.
     */
    public $table = 'vojtasvoboda_fakturoid_logs';

    /**
     * @var array $fillable Fillable fields
     */
    protected $fillable = [
        'level', 'request_method', 'request_params', 'response_status_code', 'response_headers', 'response_body',
    ];

    /**
     * @var array $dates Attributes to be cast to Argon (Carbon) instances
     */
    protected $dates = ['created_at'];

    /**
     * @var bool $timestamps If save timestamps.
     */
    public $timestamps = false;
}
