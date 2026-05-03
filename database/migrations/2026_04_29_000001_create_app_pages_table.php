<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('app_pages', function (Blueprint $table) {
            $table->id();

            $table->string('name')->nullable();
            $table->string('slug')->nullable()->unique();

            $table->text('description')->nullable();

            $table->string('logo')->nullable();

            $table->string('google_play_url')->nullable();
            $table->string('apple_store_url')->nullable();
            $table->string('direct_download_url')->nullable();

            $table->string('website_url')->nullable();

            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();

            $table->string('theme_color')->default('#2563eb');
            $table->string('secondary_color')->default('#111827');

            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('app_pages');
    }
};
