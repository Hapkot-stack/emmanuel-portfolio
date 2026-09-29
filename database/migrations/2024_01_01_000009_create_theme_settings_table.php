<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('theme_settings', function (Blueprint $table) {
            $table->id();
            $table->string('default_mode')->default('dark'); // light, dark
            $table->string('primary_color')->default('#2563EB');
            $table->string('secondary_color')->default('#06B6D4');
            $table->string('accent_color')->default('#8B5CF6');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('theme_settings'); }
};
