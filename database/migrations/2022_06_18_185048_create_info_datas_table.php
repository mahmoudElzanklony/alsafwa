<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInfoDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('info_datas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('company_id')->constrained('companies_types')->onUpdate('cascade')->onDelete('cascade');
            $table->text('item');
            $table->string('country');
            $table->string('source');
            $table->string('bill_number');
            $table->float('bill_value');
            $table->bigInteger('ACID');
            $table->string('number_container');
            $table->string('destination');
            $table->string('line');
            $table->integer('policy');
            $table->string('vehicle');
            $table->date('arrived');
            $table->string('instructions_status');
            $table->text('allowed');
            $table->text('lifting_status');
            $table->text('forty_six_number');
            $table->text('request_number');
            $table->string('statement_status');
            $table->string('notes');
            $table->date('exchange_date');
            $table->tinyInteger('matching_status');
            $table->integer('weight');
            $table->integer('number_data');
            $table->tinyInteger('status');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('info_datas');
    }
}
