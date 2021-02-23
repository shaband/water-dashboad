<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('user_addresses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('receiver_name');
            $table->string('phone')->nullable();
            $table->string('city')->nullable();
            $table->string('street')->nullable();
            $table->string('flat')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->longText('notes')->nullable();
            $table->longText('lat');
            $table->longText('lng');
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_addresses');
    }
}
