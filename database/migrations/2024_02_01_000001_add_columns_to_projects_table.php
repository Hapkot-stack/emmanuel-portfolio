<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('projects', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique()->after('title');
            $table->string('short_description')->nullable()->after('description');
            $table->text('problem')->nullable()->after('short_description');
            $table->text('solution')->nullable()->after('problem');
            $table->text('features')->nullable()->after('solution');       // JSON array
            $table->text('challenges')->nullable()->after('features');
            $table->text('lessons_learned')->nullable()->after('challenges');
            $table->text('roadmap')->nullable()->after('lessons_learned'); // JSON array
            $table->string('status')->default('draft')->after('roadmap');  // draft|published|in_development|testing|live|archived
            $table->integer('progress')->default(0)->after('status');      // 0-100%
            $table->timestamp('published_at')->nullable()->after('progress');
            $table->string('demo_video_url')->nullable()->after('published_at');
        });
    }
    public function down(): void {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn(['slug','short_description','problem','solution','features',
                'challenges','lessons_learned','roadmap','status','progress','published_at','demo_video_url']);
        });
    }
};
