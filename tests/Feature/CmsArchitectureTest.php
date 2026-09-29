<?php

namespace Tests\Feature;

use App\Models\HomepageSection;
use App\Models\CareerTrack;
use App\Models\Experience;
use App\Models\Profile;
use App\Models\ResumeType;
use App\Models\User;
use App\Filament\Admin\Pages\PublishCenter;
use App\Filament\Admin\Resources\ProjectResource;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CmsArchitectureTest extends TestCase
{
    use RefreshDatabase;

    public function test_recruiter_preview_is_not_public_and_resume_center_is_visitor_only(): void
    {
        $this->get('/recruiter')->assertNotFound();

        $this->get('/cms/recruiter-preview/site')->assertRedirect();
        $this->get('/cms/resumes/plumbing/preview')->assertRedirect();
        $this->get('/cv/plumbing/preview')->assertNotFound();

        $this->actingAs(User::factory()->create())
            ->get('/cms/recruiter-preview/site')
            ->assertOk()
            ->assertSee('Work Experience')
            ->assertSee('Career Center')
            ->assertSee('Software Developer')
            ->assertSee('Resume Center')
            ->assertSee('Developer CV')
            ->assertSee('/cv/developer/download')
            ->assertSee('Education')
            ->assertDontSee('Back to Portfolio')
            ->assertDontSee('chat-root')
            ->assertDontSee('Admin Login');

        $response = $this->get('/cv')
            ->assertOk()
            ->assertSee('Developer CV')
            ->assertSee('Laravel CV')
            ->assertSee('Maintenance Technician CV')
            ->assertSee('View Resume')
            ->assertSee('Download Resume')
            ->assertDontSee('Publish Website')
            ->assertDontSee('Generate PDF')
            ->assertDontSee('Admin Tools');

        $this->assertSame(7, substr_count($response->getContent(), 'Download Resume'));
    }

    public function test_homepage_draft_is_visible_only_on_authenticated_preview(): void
    {
        $section = HomepageSection::where('section_key', 'hero')->firstOrFail();
        $draft = $section->draft;
        $draft['title'] = 'Draft Identity';
        $section->draft = $draft;
        $section->save();

        $this->get('/')->assertOk()->assertSee('Emmanuel')->assertDontSee('Draft Identity');

        $this->actingAs(User::factory()->create())
            ->get('/cms/homepage-preview?draft=1')
            ->assertOk()
            ->assertSee('Draft')
            ->assertSee('Identity')
            ->assertSee('Draft Preview · Not Published');
    }

    public function test_section_preview_renders_only_the_selected_homepage_section_and_skill_group(): void
    {
        $this->get('/cms/homepage-preview?draft=1&section=skills-preview')->assertRedirect();

        $this->actingAs(User::factory()->create())
            ->get('/cms/homepage-preview?draft=1&section=skills-preview&skill_category=technical')
            ->assertOk()
            ->assertSee('Skills & Competencies')
            ->assertSee('Laravel')
            ->assertDontSee('hero-inner')
            ->assertDontSee('Figma');

        $this->actingAs(User::factory()->create())
            ->get('/cms/homepage-preview?draft=1&section=not-a-section')
            ->assertNotFound();

        $this->actingAs(User::factory()->create())
            ->get('/cms/homepage-preview?draft=1&section=skills-preview&skill_category=invalid')
            ->assertNotFound();
    }

    public function test_journey_section_preview_shows_only_its_assigned_content(): void
    {
        Experience::create([
            'title' => 'Preview Only Experience',
            'company' => 'Preview Test Company',
            'period' => '2024',
            'description' => 'Unique experience preview content.',
            'type' => 'work',
            'sort_order' => 1,
        ]);

        $this->get('/cms/section-preview/experience')->assertRedirect();

        $this->actingAs(User::factory()->create())
            ->get('/cms/section-preview/experience')
            ->assertOk()
            ->assertSee('Preview Only Experience')
            ->assertSee('Unique experience preview content.')
            ->assertDontSee('Skills & Competencies');

        $this->get('/cms/section-preview/not-a-section')->assertNotFound();
    }

    public function test_publish_center_publishes_drafts_and_records_versions(): void
    {
        $this->actingAs(User::factory()->create());

        $section = HomepageSection::where('section_key', 'hero')->firstOrFail();
        $draft = $section->draft;
        $draft['title'] = 'Published Identity';
        $section->draft = $draft;
        $section->save();

        app(PublishCenter::class)->publishAll();

        $section->refresh();
        $this->assertSame('Published Identity', $section->published['title']);
        $this->assertFalse($section->hasPendingChanges());
        $this->assertDatabaseHas('homepage_section_versions', [
            'homepage_section_id' => $section->id,
            'version' => 2,
            'published_by' => auth()->id(),
        ]);
    }

    public function test_resume_catalog_changes_stay_private_until_central_publish(): void
    {
        $resumeType = ResumeType::where('type_key', 'laravel')->firstOrFail();
        $draft = $resumeType->draft;
        $draft['label'] = 'Laravel Engineer Resume';
        $resumeType->draft = $draft;
        $resumeType->save();

        $this->get('/cv')->assertOk()->assertSee('Laravel CV')->assertDontSee('Laravel Engineer Resume');

        $this->actingAs(User::factory()->create());
        app(PublishCenter::class)->publishAll();

        $this->get('/cv')->assertOk()->assertSee('Laravel Engineer Resume')->assertDontSee('Laravel CV');
        $this->assertDatabaseHas('resume_type_versions', [
            'resume_type_id' => $resumeType->id,
            'version' => 2,
            'published_by' => auth()->id(),
        ]);
    }

    public function test_career_track_edits_drive_public_cards_and_landing_pages_after_publish(): void
    {
        $track = CareerTrack::where('slug', 'software-developer')->firstOrFail();
        $draft = $track->draft;
        $draft['title'] = 'Application Engineer';
        $track->draft = $draft;
        $track->save();

        $this->get('/')->assertOk()->assertSee('Software Developer')->assertDontSee('Application Engineer');
        $this->get('/career/software-developer')->assertOk()->assertSee('Software Developer')->assertDontSee('Application Engineer');
        $this->get('/cms/career/software-developer/preview')->assertRedirect();

        $this->actingAs(User::factory()->create());
        app(PublishCenter::class)->publishAll();

        $this->get('/')->assertOk()->assertSee('Application Engineer');
        $this->get('/career/software-developer')->assertOk()->assertSee('Application Engineer');
    }

    public function test_connected_cms_modules_render_for_authenticated_users(): void
    {
        $this->actingAs(User::factory()->create());

        $this->get('/cms/homepage-builder')->assertOk();
        $this->get('/cms/manage-profile')->assertOk()->assertSee('public biography')->assertSee('Back to Journey');
        $this->get('/cms/brand-center')->assertOk()->assertSee('Profile Picture')->assertSee('optimized sizes');
        $this->get('/cms/resume-types')->assertOk();
        $this->get('/cms/career-tracks')->assertOk();
        $this->get('/cms/publish-center')->assertOk();
    }

    public function test_page_management_hub_replaces_entity_navigation_without_removing_editors(): void
    {
        $this->actingAs(User::factory()->create());

        $this->get('/cms/page-management?section=journey')
            ->assertOk()
            ->assertSee('Journey')
            ->assertSee('Profile and Biography')
            ->assertSee('/cms/experiences');

        $this->get('/cms/page-management?section=expertise')
            ->assertOk()
            ->assertSee('Manage Laravel, PHP, APIs, and backend technologies.')
            ->assertSee('Backend Skills')
            ->assertSee('Edit Section')
            ->assertSee('Preview Section')
            ->assertSee('Save Draft')
            ->assertSee('Preview Page')
            ->assertSee('Publish Page');

        $this->get('/cms/page-management?section=preview-center')
            ->assertOk()
            ->assertSee('General Website Preview')
            ->assertSee('Recruiter Preview');

        $this->assertFalse(ProjectResource::shouldRegisterNavigation());
        $this->get('/cms/projects')->assertOk()->assertSee('Back to Portfolio');
        $this->get('/cms/page-management?section=unknown')->assertNotFound();
    }

    public function test_profile_avatar_keeps_original_and_generates_responsive_variants(): void
    {
        Storage::fake('public');

        $source = imagecreatetruecolor(64, 32);
        ob_start();
        imagejpeg($source);
        $original = ob_get_clean();
        imagedestroy($source);

        Storage::disk('public')->put('avatars/profile.jpg', $original);

        $profile = Profile::withoutEvents(fn() => Profile::create([
            'name' => 'Test Profile',
            'title' => 'Developer',
            'bio' => 'Profile image test',
            'email' => 'profile@example.test',
            'avatar' => 'avatars/profile.jpg',
        ]));

        $profile = Profile::findOrFail($profile->id);
        $profile->name = 'Test Profile Updated';
        $profile->save();

        $this->assertSame($original, Storage::disk('public')->get('avatars/profile.jpg'));

        foreach (['large' => 1600, 'medium' => 800, 'thumbnail' => 240] as $size => $targetSize) {
            $path = "avatars/profile-{$size}.jpg";
            Storage::disk('public')->assertExists($path);
            $image = getimagesize(Storage::disk('public')->path($path));
            $expectedSize = min($targetSize, 32);

            $this->assertSame($expectedSize, $image[0]);
            $this->assertSame($expectedSize, $image[1]);
            $this->assertStringStartsWith(asset('storage/' . $path) . '?v=', $profile->avatarUrl($size));
        }
    }
}
