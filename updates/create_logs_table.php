<?php namespace VojtaSvoboda\Fakturoid\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateLogsTable extends Migration
{
    public function up()
    {
        Schema::create('vojtasvoboda_fakturoid_logs', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('level', 20);
            $table->string('request_method', 255);
            $table->text('request_params')->nullable();
            $table->smallInteger('response_status_code', false, true);
            $table->text('response_headers')->nullable();
            $table->text('response_body')->nullable();
            $table->timestamp('created_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('vojtasvoboda_fakturoid_logs');
    }
}
