<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ichi_order_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->double('amount');
            $table->unsignedBigInteger('payment_tool_id');
            $table->foreign('payment_tool_id')->references('id')->on('wh_payment_tools')->onDelete('cascade');
            $table->unsignedBigInteger('ichi_order_id');
            $table->foreign('ichi_order_id')->references('id')->on('ichi_orders')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ichi_order_payments');
    }
};
