<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('user_name', 50)->unique();
            $table->string('email', 256)->unique();
            $table->string('phone', 25)->unique();
            $table->string('password');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->unsignedSmallInteger('status')->default(0);
            $table->unsignedSmallInteger('is_admin')->default(0);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
