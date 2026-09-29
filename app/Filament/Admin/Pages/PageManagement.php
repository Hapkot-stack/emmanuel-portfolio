<?php

namespace App\Filament\Admin\Pages;

use App\Models\CareerTrack;
use App\Models\HomepageSection;
use App\Models\Project;
use App\Models\ResumeType;
use App\Models\Skill;
use Filament\Pages\Page;

class PageManagement extends Page
{
    protected static bool $shouldRegisterNavigation = false;
    protected static string $view = 'filament.admin.pages.page-management';

    public string $section = 'home';

    private const SECTIONS = [
        'home' => [
            'title' => 'Home',
            'description' => 'Manage homepage sections, visibility, and draft content.',
            'editors' => [
                ['label' => 'Home Builder', 'description' => 'Edit homepage section content and display order.', 'url' => '/cms/homepage-builder'],
                ['label' => 'Preview Draft', 'description' => 'Review the current homepage draft.', 'url' => '/cms/homepage-preview?draft=1', 'preview' => true],
                ['label' => 'Publish Changes', 'description' => 'Review pending changes and publish the website.', 'url' => '/cms/publish-center'],
            ],
        ],
        'career-center' => [
            'title' => 'Career Center',
            'description' => 'Manage career paths and the resumes connected to each path.',
            'editors' => [
                ['label' => 'Career Paths', 'description' => 'Edit descriptions, featured work, ordering, and visibility.', 'url' => '/cms/career-tracks'],
                ['label' => 'Preview Career Page', 'description' => 'Preview the Software Developer career page.', 'url' => '/cms/career/software-developer/preview', 'preview' => true],
                ['label' => 'Publish Changes', 'description' => 'Review and publish career path drafts.', 'url' => '/cms/publish-center'],
            ],
        ],
        'resume-center' => [
            'title' => 'Resume Center',
            'description' => 'Manage public resume cards, templates, ordering, previews, and downloads.',
            'editors' => [
                ['label' => 'Resume Library', 'description' => 'Edit resume cards, templates, and visibility.', 'url' => '/cms/resume-types'],
                ['label' => 'Preview Resume', 'description' => 'Preview the Developer resume.', 'url' => '/cms/resumes/developer/preview', 'preview' => true],
                ['label' => 'Generate PDF', 'description' => 'Generate a PDF for the Developer resume.', 'url' => '/cms/resumes/developer/download'],
                ['label' => 'Publish Changes', 'description' => 'Review and publish resume drafts.', 'url' => '/cms/publish-center'],
            ],
        ],
        'expertise' => [
            'title' => 'Expertise',
            'description' => 'Manage the skills and expertise displayed across the website.',
            'editors' => [
                ['label' => 'Skills and Technologies', 'description' => 'Edit skill categories, featured items, and display order.', 'url' => '/cms/skills'],
            ],
        ],
        'portfolio' => [
            'title' => 'Portfolio',
            'description' => 'Manage project cards, featured work, screenshots, and project pages.',
            'editors' => [
                ['label' => 'Projects', 'description' => 'Edit project details, status, ordering, and visibility.', 'url' => '/cms/projects'],
            ],
        ],
        'journey' => [
            'title' => 'Journey',
            'description' => 'Manage the profile, biography, experience, education, certificates, and timeline shown to visitors.',
            'editors' => [
                ['label' => 'Profile and Biography', 'description' => 'Update public profile details and biography.', 'url' => '/cms/manage-profile'],
                ['label' => 'Experience', 'description' => 'Manage work history displayed on the site.', 'url' => '/cms/experiences'],
                ['label' => 'Education', 'description' => 'Manage public education history.', 'url' => '/cms/education'],
                ['label' => 'Certificates', 'description' => 'Manage public certificates and credentials.', 'url' => '/cms/certificates'],
                ['label' => 'Timeline', 'description' => 'Edit public milestones and timeline events.', 'url' => '/cms/timelines'],
            ],
        ],
        'connect' => [
            'title' => 'Connect',
            'description' => 'Manage public contact links and review messages submitted through the website.',
            'editors' => [
                ['label' => 'Contact Links', 'description' => 'Manage GitHub, LinkedIn, and other social links.', 'url' => '/cms/social-links'],
                ['label' => 'Contact Messages', 'description' => 'Review and update visitor inquiries.', 'url' => '/cms/contact-inquiries'],
            ],
        ],
        'hire-me' => [
            'title' => 'Hire Me',
            'description' => 'Update availability and review incoming work inquiries.',
            'editors' => [
                ['label' => 'Availability and Profile', 'description' => 'Update the availability details shown on your profile.', 'url' => '/cms/manage-profile'],
                ['label' => 'Contact Messages', 'description' => 'Review requests from prospective clients and employers.', 'url' => '/cms/contact-inquiries'],
            ],
        ],
        'brand-center' => [
            'title' => 'Brand Center',
            'description' => 'Manage the profile image and current visual identity settings.',
            'editors' => [
                ['label' => 'Profile Image', 'description' => 'Upload and crop the profile image used across the website.', 'url' => '/cms/brand-center'],
            ],
        ],
        'media-library' => [
            'title' => 'Media Library',
            'description' => 'Open the existing editors for project screenshots and certificate images.',
            'editors' => [
                ['label' => 'Project Screenshots', 'description' => 'Manage screenshots from the project editor.', 'url' => '/cms/projects'],
                ['label' => 'Certificates', 'description' => 'Manage certificate images and documents.', 'url' => '/cms/certificates'],
            ],
        ],
        'preview-center' => [
            'title' => 'Preview Center',
            'description' => 'Review the public website and authenticated previews before publishing.',
            'editors' => [
                ['label' => 'General Website Preview', 'description' => 'Open the current public website.', 'url' => '/', 'preview' => true],
                ['label' => 'Homepage Draft', 'description' => 'Preview unpublished homepage content.', 'url' => '/cms/homepage-preview?draft=1', 'preview' => true],
                ['label' => 'Recruiter Preview', 'description' => 'View a clean recruiter-facing profile.', 'url' => '/cms/recruiter-preview/site', 'preview' => true],
                ['label' => 'Career Page', 'description' => 'Preview the Software Developer career page.', 'url' => '/cms/career/software-developer/preview', 'preview' => true],
                ['label' => 'Resume', 'description' => 'Preview the Developer resume.', 'url' => '/cms/resumes/developer/preview', 'preview' => true],
            ],
        ],
        'publish-center' => [
            'title' => 'Publish Center',
            'description' => 'Review pending homepage, career path, and resume changes, and publish or roll back versions.',
            'editors' => [
                ['label' => 'Review and Publish', 'description' => 'Review drafts, publish changes, and roll back supported versions.', 'url' => '/cms/publish-center'],
            ],
        ],
        'analytics' => [
            'title' => 'Analytics',
            'description' => 'Review visits, downloads, and engagement across the public website.',
            'editors' => [
                ['label' => 'Website Analytics', 'description' => 'View page views, downloads, and visitor interactions.', 'url' => '/cms/analytics-dashboard'],
            ],
        ],
        'settings' => [
            'title' => 'Settings',
            'description' => 'Site-wide settings are not yet available in this CMS.',
            'editors' => [],
        ],
    ];

    public function mount(): void
    {
        $section = (string) request()->query('section', 'home');
        abort_unless(array_key_exists($section, self::SECTIONS), 404);
        $this->section = $section;
    }

    public function sectionContent(): array
    {
        return self::SECTIONS[$this->section];
    }

    public function sectionCards(): array
    {
        return match ($this->section) {
            'home' => $this->makeCards([
                ['Hero Section', 'Edit the homepage introduction and profile content.', '/cms/homepage-builder', '/cms/homepage-preview?draft=1&section=hero'],
                ['Featured Career Tracks', 'Choose and order featured career paths.', '/cms/homepage-builder', '/cms/homepage-preview?draft=1&section=career-center'],
                ['Featured Resume Cards', 'Choose which resumes appear on the homepage.', '/cms/homepage-builder', '/cms/homepage-preview?draft=1&section=resume-center'],
                ['Skills Preview', 'Manage the expertise preview shown on the homepage.', '/cms/homepage-builder', '/cms/homepage-preview?draft=1&section=skills-preview'],
                ['Featured Projects', 'Manage the projects highlighted on the homepage.', '/cms/homepage-builder', '/cms/homepage-preview?draft=1&section=featured-projects'],
                ['What I’m Building', 'Show current work and project progress.', '/cms/homepage-builder', '/cms/homepage-preview?draft=1&section=building-projects'],
                ['Connect Preview', 'Preview homepage social links and contact channels.', '/cms/homepage-builder', '/cms/homepage-preview?draft=1&section=social-section'],
                ['Journey Preview', 'Preview the homepage timeline section.', '/cms/homepage-builder', '/cms/homepage-preview?draft=1&section=timeline'],
                ['Contact Call To Action', 'Manage the homepage contact prompt.', '/cms/homepage-builder', '/cms/homepage-preview?draft=1&section=contact-cta'],
            ]),
            'career-center' => CareerTrack::query()->orderBy('id')->get()->map(fn(CareerTrack $track) => [
                'title' => data_get($track->draft, 'title', $track->slug),
                'description' => data_get($track->draft, 'description', 'Career path details and connected resume.'),
                'edit_url' => '/cms/career-tracks/' . $track->id . '/edit',
                'preview_url' => '/cms/career/' . $track->slug . '/preview',
            ])->all(),
            'resume-center' => ResumeType::query()->orderBy('sort_order')->get()->map(fn(ResumeType $resume) => [
                'title' => data_get($resume->draft, 'label', $resume->type_key),
                'description' => data_get($resume->draft, 'headline', 'Resume content, template, and public visibility.'),
                'edit_url' => '/cms/resume-types/' . $resume->id . '/edit',
                'preview_url' => '/cms/resumes/' . $resume->type_key . '/preview',
            ])->all(),
            'expertise' => $this->makeCards([
                ['Backend Skills', 'Manage Laravel, PHP, APIs, and backend technologies.', '/cms/skills', '/cms/homepage-preview?draft=1&section=skills-preview&skill_category=technical'],
                ['Frontend Skills', 'Manage JavaScript, Tailwind, and frontend technologies.', '/cms/skills', '/cms/homepage-preview?draft=1&section=skills-preview&skill_category=design'],
                ['Design Skills', 'Manage Figma and creative design tools.', '/cms/skills', '/cms/homepage-preview?draft=1&section=skills-preview&skill_category=design'],
                ['Business Skills', 'Manage Excel, PowerPoint, reporting, and documentation.', '/cms/skills', '/cms/homepage-preview?draft=1&section=skills-preview&skill_category=soft'],
                ['Technology Skills', 'Manage cybersecurity, networking, and technical tools.', '/cms/skills', '/cms/homepage-preview?draft=1&section=skills-preview&skill_category=tool'],
            ]),
            'portfolio' => Project::query()->orderBy('sort_order')->get()->map(fn(Project $project) => [
                'title' => $project->title,
                'description' => $project->short_description ?: $project->status_label,
                'edit_url' => '/cms/projects/' . $project->id . '/edit',
                'preview_url' => '/projects/' . $project->slug,
            ])->all(),
            'journey' => $this->makeCards([
                ['Profile and Biography', 'Update public profile details and biography.', '/cms/manage-profile', '/cms/homepage-preview?draft=1&section=hero'],
                ['Experience', 'Manage work history displayed on the site.', '/cms/experiences', '/cms/section-preview/experience'],
                ['Education', 'Manage public education history.', '/cms/education', '/cms/section-preview/education'],
                ['Certificates', 'Manage public certificates and credentials.', '/cms/certificates', '/cms/section-preview/certificates'],
                ['Timeline', 'Edit public milestones and timeline events.', '/cms/timelines', '/cms/homepage-preview?draft=1&section=timeline'],
            ]),
            'connect' => $this->makeCards([
                ['Contact Links', 'Manage GitHub, LinkedIn, and other social links.', '/cms/social-links', '/cms/homepage-preview?draft=1&section=social-section'],
                ['Contact Messages', 'Review and update visitor inquiries.', '/cms/contact-inquiries'],
            ]),
            'hire-me' => $this->makeCards([
                ['Availability and Profile', 'Update availability details shown on your profile.', '/cms/manage-profile', '/cms/section-preview/hire-me'],
                ['Contact Messages', 'Review requests from prospective clients and employers.', '/cms/contact-inquiries'],
            ]),
            'brand-center' => $this->makeCards([
                ['Profile Image', 'Upload and crop the profile image used across the website.', '/cms/brand-center', '/cms/homepage-preview?draft=1&section=hero'],
            ]),
            'media-library' => $this->makeCards([
                ['Project Screenshots', 'Manage screenshots from the project editor.', '/cms/projects', '/cms/section-preview/project-screenshots'],
                ['Certificates', 'Manage certificate images and documents.', '/cms/certificates', '/cms/section-preview/certificates'],
            ]),
            'preview-center' => collect(self::SECTIONS[$this->section]['editors'])
                ->map(fn(array $editor) => [
                    'title' => $editor['label'],
                    'description' => $editor['description'],
                    'edit_url' => null,
                    'preview_url' => $editor['url'],
                ])
                ->all(),
            default => collect(self::SECTIONS[$this->section]['editors'])
                ->map(fn(array $editor) => [
                    'title' => $editor['label'],
                    'description' => $editor['description'],
                    'edit_url' => $editor['preview'] ?? false ? null : $editor['url'],
                    'preview_url' => $editor['preview'] ?? false ? $editor['url'] : null,
                ])
                ->all(),
        };
    }

    public function pageActions(): array
    {
        $draftEditor = match ($this->section) {
            'home' => '/cms/homepage-builder',
            'career-center' => '/cms/career-tracks',
            'resume-center' => '/cms/resume-types',
            default => null,
        };

        $previewUrl = match ($this->section) {
            'home' => '/cms/homepage-preview?draft=1',
            'career-center' => '/cms/career/software-developer/preview',
            'resume-center' => '/cv',
            'expertise' => '/cms/section-preview/expertise',
            'portfolio' => '/projects',
            'journey' => '/cms/section-preview/journey',
            'connect' => '/cms/section-preview/connect',
            'hire-me' => '/cms/section-preview/hire-me',
            'brand-center' => '/cms/homepage-preview?draft=1&section=hero',
            default => null,
        };

        $hasPublishWorkflow = in_array($this->section, ['home', 'career-center', 'resume-center'], true);

        return [
            'save_draft_url' => $draftEditor,
            'preview_url' => $previewUrl,
            'can_publish' => $hasPublishWorkflow,
            'publish_url' => $hasPublishWorkflow ? '/cms/publish-center' : null,
        ];
    }

    public function pageStatus(): string
    {
        $hasPending = match ($this->section) {
            'home' => HomepageSection::all()->contains(fn(HomepageSection $section) => $section->hasPendingChanges()),
            'career-center' => CareerTrack::all()->contains(fn(CareerTrack $track) => $track->hasPendingChanges()),
            'resume-center' => ResumeType::all()->contains(fn(ResumeType $resume) => $resume->hasPendingChanges()),
            default => false,
        };

        if ($hasPending) {
            return 'Draft changes';
        }

        return in_array($this->section, ['home', 'career-center', 'resume-center'], true)
            ? 'Published'
            : 'Live';
    }

    private function makeCards(array $sections, ?string $editUrl = null, ?string $previewUrl = null): array
    {
        return collect($sections)->map(fn(array $section) => [
            'title' => $section[0],
            'description' => $section[1],
            'edit_url' => $section[2] ?? $editUrl,
            'preview_url' => $section[3] ?? $previewUrl,
        ])->all();
    }
}
