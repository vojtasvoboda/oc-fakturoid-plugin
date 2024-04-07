<?php namespace VojtaSvoboda\Fakturoid\Models;

use Carbon\Carbon;
use Model;
use October\Rain\Argon\Argon;

/**
 * @property int $invoice_id
 * @property string $number
 * @property string $status
 * @property float $total
 * @property Carbon $paid_at
 * @property string $event_name
 * @property string $invoice_custom_id
 * @property Carbon $created_at
 */
class WebhookLog extends Model
{
    /**
     * @var string $table The database table used by the model.
     */
    public $table = 'vojtasvoboda_fakturoid_webhook_logs';

    /**
     * @var array $fillable Fillable fields
     */
    protected $fillable = [
        'invoice_id', 'number', 'status', 'total', 'paid_at', 'event_name', 'invoice_custom_id',
    ];

    /**
     * @var array $dates Attributes to be cast to Argon (Carbon) instances
     */
    protected $dates = ['paid_at', 'created_at'];

    /**
     * @var bool $timestamps If save timestamps.
     */
    public $timestamps = false;

    /**
     * Before create event handler.
     */
    public function beforeCreate()
    {
        $this->created_at = Argon::now();
    }
}