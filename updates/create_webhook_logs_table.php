<?php namespace VojtaSvoboda\Fakturoid\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateWebhookLogsTable Migration
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
        Schema::create('vojtasvoboda_fakturoid_webhook_logs', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedBigInteger('invoice_id');
            $table->string('number', 300);
            $table->string('status', 10);
            $table->decimal('total', 14, 2);
            $table->date('paid_at');
            $table->string('event_name', 50);
            $table->string('invoice_custom_id', 300)->nullable();
            $table->timestamp('created_at');
        });
    }

    /**
     * down reverses the migration
     */
    public function down()
    {
        Schema::dropIfExists('vojtasvoboda_fakturoid_webhook_logs');
    }
};
