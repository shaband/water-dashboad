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
            $table->id();
            $table->string('name');
            $table->string('email')->nullable()->unique();
            $table->string('phone')->unique();
            $table->mediumInteger('phone_confirmation_code')->unique();
//            $table->timestamp('phone_code')->unique();
//            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->longText('lat')->nullable();
            $table->longText('lng')->nullable();
            $table->timestamp('phone_verified_at')->nullable();
            $table->timestamp('blocked_at')->nullable();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->string('image')->nullable();
            $table->rememberToken();
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
