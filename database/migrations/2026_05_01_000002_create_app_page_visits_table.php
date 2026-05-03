<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('app_page_visits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('app_page_id')->nullable();
            $table->string('ip')->nullable();
            $table->string('country')->nullable();
            $table->string('device')->nullable(); // mobile / desktop
            $table->string('browser')->nullable();
            $table->string('referrer')->nullable();
            $table->integer('duration')->nullable(); // seconds
            $table->string('session_id')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('app_page_visits');
    }
};
