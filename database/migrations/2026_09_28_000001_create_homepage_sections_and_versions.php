<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('homepage_sections', function (Blueprint $table) {
            $table->id();
            $table->string('section_key')->unique();
            $table->string('label');
            $table->json('draft');
            $table->json('published');
            $table->unsignedInteger('version')->default(1);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });

        Schema::create('homepage_section_versions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('homepage_section_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('version');
            $table->json('content');
            $table->foreignId('published_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->unique(['homepage_section_id', 'version']);
        });

        $sections = [
            ['hero', 'Hero Section', 'Emmanuel Tokpah', 'Software developer, information systems student, and trading systems builder.', 10],
            ['career-center', 'Career Center', 'Specialized Career Tracks', 'Tailored career tracks across software, data, infrastructure, and technical support.', 20],
            ['resume-center', 'Resume Center', 'Role-Focused Resumes', 'Explore and download a resume tailored to your next opportunity.', 30],
            ['skills-preview', 'Skills Preview', 'Skills & Competencies', 'Professional skills across software, design, business, and technology.', 40],
            ['featured-projects', 'Featured Projects', 'Featured Product Work', 'Selected software products, platforms, and technology projects.', 50],
            ['building-projects', 'What I\'m Building', 'What I\'m Building', 'Active projects with live development status.', 60],
            ['social-section', 'Social Section', 'Connect', 'Find Emmanuel across professional and developer networks.', 70],
            ['timeline', 'Timeline', 'Professional Timeline', 'A selection of career, education, and project milestones.', 80],
            ['contact-cta', 'Contact CTA', 'Let\'s Build Something', 'Get in touch about software, data, or technology opportunities.', 90],
        ];

        foreach ($sections as [$key, $label, $title, $description, $sortOrder]) {
            $content = [
                'title' => $title,
                'description' => $description,
                'visible' => true,
                'mobile_visible' => true,
                'desktop_visible' => true,
                'sort_order' => $sortOrder,
            ];

            $id = DB::table('homepage_sections')->insertGetId([
                'section_key' => $key,
                'label' => $label,
                'draft' => json_encode($content),
                'published' => json_encode($content),
                'version' => 1,
                'published_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('homepage_section_versions')->insert([
                'homepage_section_id' => $id,
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
        Schema::dropIfExists('homepage_section_versions');
        Schema::dropIfExists('homepage_sections');
    }
};
