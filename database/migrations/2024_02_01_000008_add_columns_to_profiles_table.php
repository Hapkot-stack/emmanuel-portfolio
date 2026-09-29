<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('profiles', function (Blueprint $table) {
            $table->text('bio_short')->nullable()->after('bio');
            $table->string('years_experience')->nullable()->after('bio_short');
            $table->string('open_to')->nullable()->after('years_experience'); // Fulltime, Freelance, Remote
            $table->string('resume_headline')->nullable()->after('open_to');
            $table->text('tech_stack')->nullable()->after('resume_headline'); // JSON array of chips
            $table->text('titles')->nullable()->after('tech_stack'); // JSON array for typed animation
        });
    }
    public function down(): void {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn(['bio_short','years_experience','open_to','resume_headline','tech_stack','titles']);
        });
    }
};
