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
        Schema::create('ichi_order_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('wh_inventory_branch_id')->nullable();
            $table->foreign('wh_inventory_branch_id')->references('id')->on('wh_inventory_branches')->onDelete('cascade');
            $table->integer('quantity');
            $table->double('price');
            $table->double('totalamount');
            $table->unsignedBigInteger('ichi_order_id')->nullable();
            $table->foreign('ichi_order_id')->references('id')->on('ichi_orders')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ichi_order_details');
    }
};
