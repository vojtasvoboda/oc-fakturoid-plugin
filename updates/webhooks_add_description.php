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
            $table->string('description', 300)->nullable()->after('invoice_custom_id');
        });
    }

    /**
     * down reverses the migration
     */
    public function down()
    {
        if (Schema::hasColumn('vojtasvoboda_fakturoid_webhook_logs', 'description')) {
            Schema::table('vojtasvoboda_fakturoid_webhook_logs', function (Blueprint $table) {
                $table->dropColumn('description');
            });
        }
    }
};
