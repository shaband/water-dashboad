<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromocodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('promocodes', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique()->index();
            $table->timestamp('from_date')->nullable();
            $table->timestamp('to_date')->nullable();
            $table->integer('times');
            $table->decimal('percent', 10, 6);
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
        Schema::dropIfExists('promocodes');
    }
}
