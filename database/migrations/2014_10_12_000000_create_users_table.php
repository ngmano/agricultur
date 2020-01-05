<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('user_key', 36)->nullable();
            $table->char('first_name', 255)->nullable();
            $table->char('last_name', 255)->nullable();
            $table->tinyInteger('user_type')->nullable()->comment('1 - Super Admin, 2 - User, 3 - Moderator');
            $table->text('email')->nullable();
            $table->string('password')->nullable();
            $table->tinyInteger('status')->comment('1 - Active, 0- Inactive')->default('1');
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
        Schema::dropIfExists('users');
    }
}
