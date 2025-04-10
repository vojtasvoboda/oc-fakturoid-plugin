<?php namespace VojtaSvoboda\Fakturoid\Models;

use Cache;
use Carbon\Carbon;
use Model;
use October\Rain\Argon\Argon;
use October\Rain\Database\Builder;

/**
 * @property int $id
 * @property string $level
 * @property string $request_method
 * @property string $request_params
 * @property int $response_status_code
 * @property string $response_headers
 * @property string $response_body
 * @property bool $solved
 * @property Carbon $created_at
 *
 * @method Builder notSolved()
 * @method static find(int|null $id)
 */
class Log extends Model
{
    const CACHE_KEY_NOT_SOLVED_COUNT = 'vojtasvoboda.fakturoid:log.not_solved_count';

    const CACHE_EXPIRATION_NOT_SOLVED_COUNT = 60 * 10;

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

    /**
     * Before create event handler.
     */
    public function beforeCreate()
    {
        $this->created_at = Argon::now();
    }

    public function afterCreate()
    {
        Cache::forget(self::CACHE_KEY_NOT_SOLVED_COUNT);
    }

    public function scopeNotSolved(Builder $query): Builder
    {
        return $query->where('solved', false);
    }

    public function getUnsolvedCount(): int
    {
        $cache_key = Log::CACHE_KEY_NOT_SOLVED_COUNT;
        $cache_expiration = Log::CACHE_EXPIRATION_NOT_SOLVED_COUNT;

        return Cache::remember($cache_key, $cache_expiration, function() {
            return $this->notSolved()->count();
        });
    }

    public function setSolved(): void
    {
        $this->solved = true;
        $this->save();

        Cache::decrement(self::CACHE_KEY_NOT_SOLVED_COUNT);
    }

    public function unsetSolved(): void
    {
        $this->solved = false;
        $this->save();

        Cache::increment(self::CACHE_KEY_NOT_SOLVED_COUNT);
    }
}
