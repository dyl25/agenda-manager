<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->string('name', 50);
            $table->smallInteger('places')->default(1)->nullable();
            //$table->string('day_fom', 15);
            //$table->string('day_to', 15);
            $table->tinyInteger('monday')->default(0)->nullable();
            $table->tinyInteger('tuesday')->default(0)->nullable();
            $table->tinyInteger('wednesday')->default(0)->nullable();
            $table->tinyInteger('thursday')->default(0)->nullable();
            $table->tinyInteger('friday')->default(0)->nullable();
            $table->tinyInteger('saturday')->default(0)->nullable();
            $table->tinyInteger('sunday')->default(0)->nullable();
            /*$table->string('start_time', 4);
            $table->string('end_time', 4);*/
            $table->string('duration', 4);
            $table->decimal('price', 9, 3);
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
        Schema::dropIfExists('service_settings');
    }
}
