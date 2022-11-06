<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_id');
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone');
            $table->string('customer_street');
            $table->string('customer_city');
            $table->string('customer_state');
            $table->string('customer_zipcode');
            $table->string('customer_country');
            $table->string('product_name');
            $table->text('product_details');
            $table->decimal('amount', 10, 2)->notnull();
            $table->enum('payment_status', ['PAID', 'PENDING', 'EXPIRED', 'FULFILLED', 'REFUND'])->default('PENDING');
            $table->string('payment_url');
            $table->tinyInteger('status')->default('1');
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
        Schema::dropIfExists('orders');
    }
}
