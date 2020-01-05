<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProcessFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('process_fields', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('process_field_key', 36)->nullable();
            $table->unsignedBigInteger('tractor_id')
                ->foreign('tractor_id')
                ->references('id')
                ->on('tractors')
                ->nullable();
            $table->unsignedBigInteger('field_id')
                ->foreign('field_id')
                ->references('id')
                ->on('fields')
                ->nullable();
            $table->date('date')->nullable();
            $table->double('area')->nullable();
            $table->tinyInteger('status')
                ->nullable()
                ->comment('1 - Pending, 2- Approved')
                ->default('1');
            $table->bigInteger('created_user_id')->nullable();
            $table->bigInteger('updated_user_id')->nullable();
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
        Schema::dropIfExists('process_fields');
    }
}
