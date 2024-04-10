<?php namespace VojtaSvoboda\Fakturoid\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * WebhooksMakeDateNullable Migration
 *
 * @link https://docs.octobercms.com/3.x/extend/database/structure.html
 */
return new class extends Migration
{
    /**
     * up builds the migration
     */
    public function up()
    {
        Schema::table('vojtasvoboda_fakturoid_webhook_logs', function(Blueprint $table) {
            $table->date('paid_at')->nullable()->change();
        });
    }

    /**
     * down reverses the migration
     */
    public function down()
    {
        Schema::table('vojtasvoboda_fakturoid_webhook_logs', function(Blueprint $table) {
            $table->date('paid_at')->nullable(false)->change();
        });
    }
};
