<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable()->index();
            $table->foreignId('agent_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('address_id')->nullable()->constrained()->cascadeOnDelete();
            $table->date('delivering_date')->nullable();
            $table->time('delivering_time')->nullable();
            $table->foreignId('user_address_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('delivery_id')->nullable()->constrained()->cascadeOnDelete();
            $table->timestamp('agent_accepted_at')->nullable();
            $table->timestamp('delivery_accepted_at')->nullable();
            $table->enum('canceled_by', ["agent","delivery","user"])->nullable();
            $table->timestamp('canceled_at')->nullable();
            $table->string('payment_type')->default('cash');
            $table->foreignId('promocode_id')->nullable()->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('is_charity')->default(0)->index();
            $table->enum('status', ["new","delivery_approval","delivering","finished","canceled"])->default('new');
            $table->longText('notes')->nullable();
            $table->decimal('price', 10, 6);
            $table->decimal('delivery_price', 10, 6);
            $table->decimal('discount', 10, 6);
            $table->decimal('tax', 10, 6);
            $table->longText('lat')->nullable();
            $table->longText('lng')->nullable();
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
        Schema::dropIfExists('invoices');
    }
}
