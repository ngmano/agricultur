<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fields', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('field_key', 36)->nullable();
            $table->char('field_name', 255)->nullable();
            $table->tinyInteger('field_type')
                ->nullable()
                ->comment('1 - Wheat, 2 - Broccoli, 3 - Strawberries');
            $table->double('area')->nullable();
            $table->tinyInteger('status')
                ->nullable()
                ->comment('1 - Active, 0- Inactive')
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
        Schema::dropIfExists('fields');
    }
}
