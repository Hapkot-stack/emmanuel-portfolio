<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('seo_settings', function (Blueprint $table) {
            $table->id();
            $table->string('meta_title');
            $table->text('meta_description');
            $table->string('meta_keywords')->nullable();
            $table->string('og_image')->nullable();
            $table->string('favicon')->nullable();
            $table->string('google_analytics')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('seo_settings'); }
};
