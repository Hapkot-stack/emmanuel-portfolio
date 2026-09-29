<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('career_tracks', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->json('draft');
            $table->json('published');
            $table->unsignedInteger('version')->default(1);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });

        Schema::create('career_track_versions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('career_track_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('version');
            $table->json('content');
            $table->foreignId('published_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->unique(['career_track_id', 'version']);
        });

        $tracks = [
            ['software-developer', 'Software Developer', 'Software', 'Building Laravel apps, APIs, dashboards, and full-stack business systems.', 'developer'],
            ['laravel-developer', 'Laravel Developer', 'Software', 'Backend architecture, MySQL systems, business workflows, and operational tooling.', 'laravel'],
            ['ict-officer', 'ICT Officer', 'ICT', 'Systems support, infrastructure, productivity tools, and digital operations.', 'ict-officer'],
            ['data-officer', 'Data Officer', 'Data', 'Reporting, analytics, data collection, and evidence-based decision systems.', 'data-officer'],
            ['ngo-technology', 'NGO Technology', 'NGO & Impact', 'Documentation, reporting, digital transformation, and humanitarian systems.', 'ngo'],
            ['documentation-specialist', 'Documentation Specialist', 'Data & Operations', 'Clear technical documentation, structured reporting, and knowledge management.', 'data-officer'],
            ['electrical-technician', 'Electrical Technician', 'Electrical', 'Maintenance, installation, infrastructure reliability, and technical troubleshooting.', 'electrical'],
            ['industrial-electrical', 'Industrial Electrical', 'Electrical', 'Industrial electrical systems, maintenance, safety, and troubleshooting.', 'industrial-electrical'],
            ['maintenance-technician', 'Maintenance Technician', 'Technical', 'Preventive maintenance, fault diagnosis, and reliable facilities operations.', 'maintenance'],
            ['plumbing', 'Plumbing Technician', 'Technical', 'Installation, maintenance, troubleshooting, and facilities operations.', 'plumbing'],
        ];

        foreach ($tracks as $index => [$slug, $title, $category, $description, $resumeType]) {
            $content = [
                'title' => $title,
                'category' => $category,
                'description' => $description,
                'resume_type' => $resumeType,
                'is_public' => true,
                'sort_order' => ($index + 1) * 10,
                'featured_skill_ids' => [],
                'featured_project_ids' => [],
            ];

            $id = DB::table('career_tracks')->insertGetId([
                'slug' => $slug,
                'draft' => json_encode($content),
                'published' => json_encode($content),
                'version' => 1,
                'published_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('career_track_versions')->insert([
                'career_track_id' => $id,
                'version' => 1,
                'content' => json_encode($content),
                'published_by' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('career_track_versions');
        Schema::dropIfExists('career_tracks');
    }
};
