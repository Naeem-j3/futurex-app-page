<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('app_page_clicks', function (Blueprint $table) {
            $table->id();

            $table->foreignId('app_page_id')->nullable();

            $table->string('type'); // google_play / apple / website / download

            $table->string('ip')->nullable();
            $table->string('country')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('app_page_clicks');
    }
};
