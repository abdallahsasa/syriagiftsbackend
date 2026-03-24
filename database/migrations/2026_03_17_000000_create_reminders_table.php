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
        Schema::create('reminders', function (Blueprint $box) {
            $box->id();
            $box->foreignId('user_id')->constrained()->onDelete('cascade');
            $box->string('name');
            $box->date('date');
            $box->string('occasion_type')->nullable();
            $box->boolean('is_active')->default(true);
            $box->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reminders');
    }
};
