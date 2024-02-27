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
        Schema::create('tbl_transaction_history', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reference_id');
            $table->foreign('reference_id')->references('id')->on('tbl_requests')->onDelete('cascade');
            $table->string('action_taken', 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_transaction_history');
    }
};
