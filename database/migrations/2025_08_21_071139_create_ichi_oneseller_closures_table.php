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
        Schema::create('ichi_oneseller_closures', function (Blueprint $table) {
            $table->unsignedBigInteger('ancestor_id')->nullable();
            $table->foreign('ancestor_id')->references('id')->on('ichi_onesellers')->onDelete('cascade');
            $table->unsignedBigInteger('descendant_id')->nullable();
            $table->foreign('descendant_id')->references('id')->on('ichi_onesellers')->onDelete('cascade');
            $table->integer('depth');
            $table->unique(['ancestor_id', 'descendant_id']);
            $table->index(['ancestor_id', 'depth']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ichi_oneseller_closures');
    }
};
