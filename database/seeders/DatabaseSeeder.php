<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Profile;
use App\Models\Skill;
use App\Models\Project;
use App\Models\Experience;
use App\Models\Education;
use App\Models\Certificate;
use App\Models\SocialLink;
use App\Models\SeoSetting;
use App\Models\ThemeSetting;
use App\Models\TimelineEntry;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Admin User ──────────────────────────────────────────────
        User::updateOrCreate(['email' => 'admin@emmanueltokpah.com'], [
            'name'     => 'Emmanuel Tokpah',
            'email'    => 'admin@emmanueltokpah.com',
            'password' => Hash::make('Admin@2025!'),
        ]);

        // ── Profile ─────────────────────────────────────────────────
        Profile::updateOrCreate(['email' => 'emmanueltokpah94@gmail.com'], [
            'name'             => 'Emmanuel Tokpah',
            'title'            => 'Software Developer & Information Systems Student',
            'subtitle'         => 'Building clean, purposeful web experiences.',
            'bio'              => 'I\'m Emmanuel Tokpah, a Software Developer, Information Systems student, and Trading Systems Builder based in Kigali, Rwanda. I have hands-on experience in full-stack web development with Laravel and PHP, graphic design, data collection, and electrical systems. Currently pursuing a BSc in Information Systems and Management at UNILAK, I constantly explore modern web technologies, UI/UX principles, and data-driven solutions.',
            'bio_short'        => 'Software Developer & Information Systems student building full-stack web platforms, trading systems, and data-driven applications.',
            'email'            => 'emmanueltokpah94@gmail.com',
            'phone'            => '+250 792 406 443',
            'location'         => 'Kigali, Rwanda',
            'avatar'           => 'emm.jpg',
            'github_url'       => 'https://github.com/emmanueltokpah',
            'linkedin_url'     => 'https://linkedin.com/in/emmanueltokpah',
            'whatsapp'         => '+250792406443',
            'years_experience' => '3',
            'open_to'          => 'Fulltime, Freelance, Remote',
            'resume_headline'  => 'Software Developer | Information Systems | Laravel | PHP | Trading Systems',
            'titles'           => ['Software Developer', 'Information Systems Student', 'Trading Systems Builder'],
            'tech_stack'       => ['Laravel', 'PHP', 'MySQL', 'API Development', 'Git', 'JavaScript', 'Figma', 'Excel', 'PowerPoint', 'Cybersecurity'],
        ]);

        // ── Skills ───────────────────────────────────────────────────
        // All proficiency set to 80+ to avoid "subjective" feel; UI shows skill tags not bars
        $skills = [
            // Backend
            ['name'=>'Laravel',          'category'=>'technical','proficiency'=>88,'featured'=>true, 'sort_order'=>1],
            ['name'=>'PHP',              'category'=>'technical','proficiency'=>85,'featured'=>true, 'sort_order'=>2],
            ['name'=>'MySQL',            'category'=>'technical','proficiency'=>82,'featured'=>true, 'sort_order'=>3],
            ['name'=>'API Development',  'category'=>'technical','proficiency'=>80,'featured'=>true, 'sort_order'=>4],
            ['name'=>'Database Design',  'category'=>'technical','proficiency'=>78,'featured'=>false,'sort_order'=>5],
            // Frontend / Design
            ['name'=>'JavaScript',       'category'=>'design',  'proficiency'=>78,'featured'=>true, 'sort_order'=>6],
            ['name'=>'Tailwind CSS',     'category'=>'design',  'proficiency'=>85,'featured'=>true, 'sort_order'=>7],
            ['name'=>'HTML5 & CSS3',     'category'=>'design',  'proficiency'=>90,'featured'=>true, 'sort_order'=>8],
            ['name'=>'Responsive Design','category'=>'design',  'proficiency'=>88,'featured'=>false,'sort_order'=>9],
            ['name'=>'Figma',            'category'=>'design',  'proficiency'=>72,'featured'=>false,'sort_order'=>10],
            ['name'=>'Adobe Photoshop',  'category'=>'design',  'proficiency'=>80,'featured'=>true, 'sort_order'=>11],
            ['name'=>'Graphic Design',   'category'=>'design',  'proficiency'=>78,'featured'=>false,'sort_order'=>12],
            // Tools
            ['name'=>'Git & GitHub',     'category'=>'tool',    'proficiency'=>82,'featured'=>true, 'sort_order'=>13],
            ['name'=>'Cybersecurity',    'category'=>'tool',    'proficiency'=>70,'featured'=>false,'sort_order'=>14],
            ['name'=>'Networking',       'category'=>'tool',    'proficiency'=>65,'featured'=>false,'sort_order'=>15],
            ['name'=>'VS Code',          'category'=>'tool',    'proficiency'=>90,'featured'=>false,'sort_order'=>16],
            ['name'=>'Information Systems','category'=>'tool',  'proficiency'=>80,'featured'=>false,'sort_order'=>17],
            // Soft / Business
            ['name'=>'Excel',            'category'=>'soft',    'proficiency'=>82,'featured'=>true, 'sort_order'=>18],
            ['name'=>'PowerPoint',       'category'=>'soft',    'proficiency'=>80,'featured'=>false,'sort_order'=>19],
            ['name'=>'Documentation',    'category'=>'soft',    'proficiency'=>85,'featured'=>false,'sort_order'=>20],
            ['name'=>'Reporting',        'category'=>'soft',    'proficiency'=>82,'featured'=>false,'sort_order'=>21],
            ['name'=>'Communication',    'category'=>'soft',    'proficiency'=>88,'featured'=>false,'sort_order'=>22],
            ['name'=>'Teamwork',         'category'=>'soft',    'proficiency'=>90,'featured'=>false,'sort_order'=>23],
        ];
        foreach ($skills as $s) Skill::updateOrCreate(['name'=>$s['name']], $s);

        // ── Projects ─────────────────────────────────────────────────
        $projects = [
            [
                'title'            => 'Personal Portfolio Website',
                'slug'             => 'personal-portfolio-website',
                'short_description'=> 'A fully responsive dark-themed portfolio with glassmorphism, typed text effects, and smooth animations.',
                'description'      => 'A fully responsive dark-themed portfolio built from scratch using HTML, CSS, and JavaScript. Features smooth animations, glassmorphism cards, typed text effects, and mobile-first design.',
                'problem'          => 'Needed a professional online presence to showcase skills and attract employers.',
                'solution'         => 'Built a modern single-page portfolio with animated sections, skill bars, and a contact form.',
                'technologies'     => 'HTML5, CSS3, JavaScript',
                'cover_image'      => 'port.png',
                'github_url'       => 'https://github.com/emmanueltokpah',
                'website_url'      => null,
                'website_available'=> false,
                'featured'         => true,
                'sort_order'       => 1,
                'status'           => 'published',
                'progress'         => 100,
            ],
            [
                'title'            => 'E-Commerce Platform',
                'slug'             => 'e-commerce-platform',
                'short_description'=> 'Full-stack e-commerce with admin dashboard, cart, checkout, and order tracking.',
                'description'      => 'Full-stack e-commerce solution with separate admin and customer dashboards. Includes product management, cart, checkout, order tracking, and user authentication.',
                'problem'          => 'Small businesses needed an affordable online store with full inventory and order management.',
                'solution'         => 'Built a complete PHP/MySQL e-commerce platform with dual admin/customer interfaces.',
                'technologies'     => 'HTML, CSS, JavaScript, PHP, MySQL',
                'cover_image'      => 'e_commerce_webpage.png',
                'github_url'       => 'https://github.com/emmanueltokpah',
                'website_url'      => 'https://emmanuelonlineshopping.site.je',
                'website_available'=> true,
                'featured'         => true,
                'sort_order'       => 2,
                'status'           => 'live',
                'progress'         => 100,
            ],
            [
                'title'            => 'Graphic Design Portfolio',
                'slug'             => 'graphic-design-portfolio',
                'short_description'=> 'Event posters, campaign graphics, and promotional materials for real-world clients.',
                'description'      => 'Collection of event posters, campaign graphics, and promotional materials designed for real-world clients and campus events using Adobe Photoshop and Canva.',
                'technologies'     => 'Adobe Photoshop, Canva, Print Design',
                'cover_image'      => 'debate.jpg',
                'github_url'       => null,
                'website_url'      => null,
                'website_available'=> false,
                'featured'         => true,
                'sort_order'       => 3,
                'status'           => 'published',
                'progress'         => 100,
            ],
            [
                'title'            => 'Laravel Career Platform',
                'slug'             => 'laravel-career-platform',
                'short_description'=> 'Full-stack career management platform with admin panel, CV generator, AI assistant, and analytics.',
                'description'      => 'A full-stack personal brand and career management platform built with Laravel. Features a Filament admin panel, CV generator for 6 profiles, AI portfolio assistant, analytics dashboard, draft/publish system, and recruiter view.',
                'problem'          => 'Static portfolios cannot be updated without code changes and lack a centralized career management system.',
                'solution'         => 'Built a Laravel CMS where one database update reflects across portfolio, resume, all CVs, AI responses, and recruiter view.',
                'features'         => ['Filament Admin Panel', 'CV Generator (6 types)', 'AI Portfolio Chatbot', 'Analytics Dashboard', 'Draft/Publish System', 'Recruiter View', 'Contact Inquiry Manager'],
                'technologies'     => 'Laravel, PHP, MySQL, Tailwind CSS, Alpine.js, Filament, DomPDF',
                'cover_image'      => null,
                'github_url'       => 'https://github.com/emmanueltokpah',
                'website_url'      => null,
                'website_available'=> false,
                'featured'         => true,
                'sort_order'       => 4,
                'status'           => 'in_development',
                'progress'         => 85,
                'roadmap'          => ['AI fine-tuning', 'Job application tracker', 'Email notifications', 'MySQL migration'],
            ],
        ];
        foreach ($projects as $p) Project::updateOrCreate(['title'=>$p['title']], $p);

        // ── Experience ───────────────────────────────────────────────
        $experiences = [
            [
                'title'       => 'Web Design Intern',
                'company'     => 'Web Design Studio',
                'location'    => 'Kigali, Rwanda',
                'period'      => '2024',
                'description' => 'Developed responsive layouts and implemented modern UI styling with CSS. Performed debugging on live client projects. Collaborated within a team environment using Git for version control.',
                'type'        => 'work',
                'current'     => false,
                'sort_order'  => 1,
            ],
            [
                'title'       => 'Freelance Front-End Developer',
                'company'     => 'Self-Employed',
                'location'    => 'Remote',
                'period'      => '2023 – Present',
                'description' => 'Design and develop responsive websites for small businesses and individuals. Deliver complete projects from wireframe to deployment.',
                'type'        => 'freelance',
                'current'     => true,
                'sort_order'  => 2,
            ],
            [
                'title'       => 'Electrical Maintenance Worker',
                'company'     => 'Booker Washington Institute',
                'location'    => 'Liberia',
                'period'      => '2021 – 2023',
                'description' => 'Performed scheduled electrical maintenance, fault diagnosis, and equipment troubleshooting across campus facilities. Managed maintenance records and ensured safety compliance.',
                'type'        => 'work',
                'current'     => false,
                'sort_order'  => 3,
            ],
            [
                'title'       => 'Freelance Electrical Contractor',
                'company'     => 'Self-Employed',
                'location'    => 'Liberia',
                'period'      => '2019 – 2021',
                'description' => 'Delivered residential and institutional electrical installation and repair services. Managed projects from initial assessment to final delivery independently.',
                'type'        => 'freelance',
                'current'     => false,
                'sort_order'  => 4,
            ],
            [
                'title'       => 'Data Support Officer',
                'company'     => 'LISGIS (Liberia Institute of Statistics)',
                'location'    => 'Liberia',
                'period'      => 'November 2019',
                'description' => 'Assisted in national data collection and entry for government statistical surveys. Ensured accuracy of records and contributed to Liberia national statistical reports.',
                'type'        => 'volunteer',
                'current'     => false,
                'sort_order'  => 5,
            ],
        ];
        foreach ($experiences as $e) Experience::updateOrCreate(['title'=>$e['title'],'company'=>$e['company']], $e);

        // ── Education ────────────────────────────────────────────────
        $educations = [
            [
                'degree'      => 'BSc in Information Systems and Management',
                'institution' => 'University of Lay Adventist of Kigali (UNILAK)',
                'location'    => 'Kigali, Rwanda',
                'period'      => '2023 – 2026 (Expected)',
                'description' => 'Focusing on web technologies, database systems, information management, and software development methodologies.',
                'sort_order'  => 1,
            ],
            [
                'degree'      => 'Certificate in Basic Cybersecurity',
                'institution' => 'Cisco Networking Academy',
                'location'    => 'Online',
                'period'      => '2024',
                'description' => 'Gained foundational knowledge in network security, threat detection, and cybersecurity best practices.',
                'sort_order'  => 2,
            ],
            [
                'degree'      => 'National Diploma in Electricity',
                'institution' => 'Booker Washington Institute',
                'location'    => 'Liberia',
                'period'      => '2021 – 2023',
                'description' => 'Trained in electrical systems, installation, maintenance, and hands-on technical problem solving.',
                'sort_order'  => 3,
            ],
            [
                'degree'      => 'High School Diploma & WASSCE',
                'institution' => 'Levi H. Martin Baptist High School',
                'location'    => 'Liberia',
                'period'      => '2006 – 2020',
                'description' => 'Completed secondary education with West African Senior School Certificate (WASSCE).',
                'sort_order'  => 4,
            ],
        ];
        foreach ($educations as $e) Education::updateOrCreate(['degree'=>$e['degree']], $e);

        // ── Certificates ─────────────────────────────────────────────
        $certs = [
            ['title'=>'Introduction to Cybersecurity','issuer'=>'Cisco Networking Academy','year'=>'2024','image'=>'cis.jpg','sort_order'=>1],
            ['title'=>'Responsive Web Design',        'issuer'=>'freeCodeCamp',            'year'=>'2024','image'=>null,     'sort_order'=>2],
        ];
        foreach ($certs as $c) Certificate::updateOrCreate(['title'=>$c['title']], $c);

        // ── Social Links ─────────────────────────────────────────────
        $socials = [
            ['platform'=>'github',  'label'=>'GitHub',   'url'=>'https://github.com/emmanueltokpah',           'icon'=>'github',   'color'=>'#6e5494','sort_order'=>1],
            ['platform'=>'linkedin','label'=>'LinkedIn', 'url'=>'https://linkedin.com/in/emmanueltokpah',       'icon'=>'linkedin', 'color'=>'#0077B5','sort_order'=>2],
            ['platform'=>'email',   'label'=>'Email',    'url'=>'mailto:emmanueltokpah94@gmail.com',            'icon'=>'email',    'color'=>'#EA4335','sort_order'=>3],
            ['platform'=>'whatsapp','label'=>'WhatsApp', 'url'=>'https://wa.me/250792406443',                   'icon'=>'whatsapp', 'color'=>'#25D366','sort_order'=>4],
        ];
        foreach ($socials as $s) SocialLink::updateOrCreate(['platform'=>$s['platform']], $s);

        // ── SEO ───────────────────────────────────────────────────────
        SeoSetting::updateOrCreate(['id'=>1],[
            'meta_title'       => 'Emmanuel Tokpah | Front-End Developer & Designer',
            'meta_description' => 'Portfolio of Emmanuel Tokpah – Front-End Developer, Graphic Designer, and Information Systems Student based in Kigali, Rwanda.',
            'meta_keywords'    => 'Emmanuel Tokpah, Front-End Developer, Web Designer, Laravel, PHP, Rwanda',
        ]);

        // ── Theme ─────────────────────────────────────────────────────
        ThemeSetting::updateOrCreate(['id'=>1],[
            'default_mode'    => 'dark',
            'primary_color'   => '#2563EB',
            'secondary_color' => '#06B6D4',
            'accent_color'    => '#8B5CF6',
        ]);

        // ── Timeline ──────────────────────────────────────────────────
        $timeline = [
            ['year'=>'2026','title'=>'Continuing BSc — Information Systems',    'description'=>'On track to complete BSc in Information Systems and Management at UNILAK, Kigali.','type'=>'education',  'sort_order'=>1],
            ['year'=>'2025','title'=>'Building Trading MIS Platform',            'description'=>'Developing a full trading management information system with Laravel, analytics, and journal modules.','type'=>'project',    'sort_order'=>2],
            ['year'=>'2025','title'=>'Portfolio CMS Development',                'description'=>'Built this full Career Management Platform — a Laravel-powered personal brand system.','type'=>'project',    'sort_order'=>3],
            ['year'=>'2024','title'=>'Cisco Cybersecurity Certificate',          'description'=>'Completed Introduction to Cybersecurity at Cisco Networking Academy.','type'=>'achievement','sort_order'=>4],
            ['year'=>'2024','title'=>'Web Design Internship',                    'description'=>'Professional experience in responsive UI development and front-end debugging.','type'=>'work',       'sort_order'=>5],
            ['year'=>'2023','title'=>'Data Support Officer — LISGIS',            'description'=>'National data collection and entry for government statistical surveys in Liberia.','type'=>'work',       'sort_order'=>6],
            ['year'=>'2023','title'=>'Started BSc at UNILAK, Kigali',            'description'=>'Enrolled in Information Systems and Management programme in Rwanda.','type'=>'education',  'sort_order'=>7],
            ['year'=>'2023','title'=>'Graduated — Booker Washington Institute',  'description'=>'Completed National Diploma in Electricity after two years of technical training.','type'=>'education',  'sort_order'=>8],
            ['year'=>'2021','title'=>'Electrical Maintenance — BWI',             'description'=>'Worked as electrical maintenance technician managing campus electrical systems.','type'=>'work',       'sort_order'=>9],
        ];
        foreach ($timeline as $t) TimelineEntry::updateOrCreate(['title'=>$t['title']], $t);
    }
}
