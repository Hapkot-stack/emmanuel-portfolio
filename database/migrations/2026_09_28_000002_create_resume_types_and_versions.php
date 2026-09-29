<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('resume_types', function (Blueprint $table) {
            $table->id();
            $table->string('type_key')->unique();
            $table->string('template');
            $table->unsignedInteger('sort_order')->default(0);
            $table->json('draft');
            $table->json('published');
            $table->unsignedInteger('version')->default(1);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });

        Schema::create('resume_type_versions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resume_type_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('version');
            $table->json('content');
            $table->foreignId('published_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->unique(['resume_type_id', 'version']);
        });

        $types = [
            ['developer', 'developer', 'Developer CV', 'Software Developer', 'Laravel, backend systems, APIs, and software projects', '💻', '#2563EB', true, 10],
            ['laravel', 'developer', 'Laravel CV', 'Laravel Developer', 'Laravel applications, PHP, MySQL, APIs, and business workflows', '⚙️', '#F05240', true, 20],
            ['ict-officer', 'ict_officer', 'ICT Officer CV', 'ICT Officer', 'Networking, cybersecurity, IT support, and information systems', '🖥️', '#0284C7', true, 30],
            ['data-officer', 'data_officer', 'Data Officer CV', 'Data Officer', 'Data collection, analytics, reporting, and documentation', '📊', '#7C3AED', true, 40],
            ['ngo', 'ngo', 'NGO Technology CV', 'NGO Technology Professional', 'Information systems, reporting, documentation, and community impact', '🌍', '#059669', true, 50],
            ['electrical', 'electrical', 'Electrical Technician CV', 'Electrical Technician', 'Electrical systems, maintenance, installation, and troubleshooting', '⚡', '#D97706', true, 60],
            ['maintenance', 'electrical', 'Maintenance Technician CV', 'Maintenance Technician', 'Preventive maintenance, troubleshooting, and technical operations', '🔧', '#0F766E', true, 70],
            ['industrial-electrical', 'electrical', 'Industrial Electrical CV', 'Industrial Electrical Technician', 'Industrial systems, electrical maintenance, and safety', '🏭', '#B45309', false, 80],
            ['plumbing', 'electrical', 'Plumbing CV', 'Plumbing Technician', 'Installation, maintenance, and facilities troubleshooting', '🔩', '#0891B2', false, 90],
            ['one-page', 'one_page', 'One Page Resume', 'Software Developer', 'A concise summary of profile, skills, experience, and education', '📄', '#2563EB', false, 100],
        ];

        foreach ($types as [$key, $template, $label, $headline, $focus, $icon, $color, $public, $sortOrder]) {
            $content = [
                'template' => $template,
                'sort_order' => $sortOrder,
                'label' => $label,
                'headline' => $headline,
                'focus' => $focus,
                'summary' => null,
                'icon' => $icon,
                'color' => $color,
                'is_public' => $public,
            ];

            $id = DB::table('resume_types')->insertGetId([
                'type_key' => $key,
                'template' => $template,
                'sort_order' => $sortOrder,
                'draft' => json_encode($content),
                'published' => json_encode($content),
                'version' => 1,
                'published_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('resume_type_versions')->insert([
                'resume_type_id' => $id,
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
        Schema::dropIfExists('resume_type_versions');
        Schema::dropIfExists('resume_types');
    }
};
