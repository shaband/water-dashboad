<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->longText('precent')->nullable();
            $table->decimal('price')->nullable();
            $table->foreignId('agent_id')->constrained()->cascadeOnDelete();
            $table->foreignId('agent_product_id')->constrained()->cascadeOnDelete();
            $table->integer('quantity')->nullable();
            $table->timestamp('start_at')->nullable();
            $table->timestamp('finish_at')->nullable();
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
        Schema::dropIfExists('offers');
    }
}
