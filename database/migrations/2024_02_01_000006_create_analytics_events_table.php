<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('analytics_events', function (Blueprint $table) {
            $table->id();
            $table->string('event_type'); // page_view|cv_download|github_click|linkedin_click|project_view|contact_submit
            $table->string('page')->nullable();
            $table->string('label')->nullable(); // e.g. CV type, project name
            $table->string('ip_address')->nullable();
            $table->string('country')->nullable();
            $table->text('user_agent')->nullable();
            $table->string('referrer')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('analytics_events'); }
};
