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
        Schema::create('tbl_users', function (Blueprint $table) {
            $table->id();
            $table->string('username', 50);
            $table->string('password');
            $table->string('fname', 50)->nullable();
            $table->string('mname', 50)->nullable();
            $table->string('lname', 50)->nullable();
            $table->boolean('isActive')->default(true);
            $table->unsignedBigInteger('department_id');
            $table->foreign('department_id')->references('id')->on('tbl_departments')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_users');
    }
};
