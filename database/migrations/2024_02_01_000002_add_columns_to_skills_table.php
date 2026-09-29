<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('skills', function (Blueprint $table) {
            $table->string('color')->nullable()->after('icon');     // hex color
            $table->string('badge_label')->nullable()->after('color'); // e.g. "Expert"
        });
    }
    public function down(): void {
        Schema::table('skills', function (Blueprint $table) {
            $table->dropColumn(['color','badge_label']);
        });
    }
};
