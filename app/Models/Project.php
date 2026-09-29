<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Project extends Model
{
    protected $fillable = [
        'title','slug','description','short_description','problem','solution',
        'features','challenges','lessons_learned','roadmap','technologies',
        'cover_image','github_url','website_url','website_available','demo_video_url',
        'featured','sort_order','status','progress','published_at',
    ];

    protected $casts = [
        'website_available' => 'boolean',
        'featured'          => 'boolean',
        'published_at'      => 'datetime',
        'features'          => 'array',
        'roadmap'           => 'array',
    ];

    /* ── Statuses ────────────────────────────────── */
    const STATUSES = [
        'draft'          => 'Draft',
        'published'      => 'Published',
        'in_development' => 'In Development',
        'testing'        => 'Testing',
        'live'           => 'Live',
        'archived'       => 'Archived',
    ];

    const STATUS_COLORS = [
        'draft'          => 'gray',
        'published'      => 'blue',
        'in_development' => 'orange',
        'testing'        => 'yellow',
        'live'           => 'green',
        'archived'       => 'red',
    ];

    /* ── Scopes ──────────────────────────────────── */
    public function scopePublished($query)       { return $query->where('status', 'published')->orWhere('status', 'live'); }
    public function scopeFeatured($query)        { return $query->where('featured', true); }
    public function scopeVisible($query)         { return $query->whereNotIn('status', ['draft']); }

    /* ── Relationships ───────────────────────────── */
    public function screenshots(): HasMany { return $this->hasMany(ProjectScreenshot::class)->orderBy('sort_order'); }

    /* ── Accessors ───────────────────────────────── */
    public function getTechArrayAttribute(): array
    {
        return array_filter(array_map('trim', explode(',', $this->technologies ?? '')));
    }

    public function getStatusColorAttribute(): string
    {
        return self::STATUS_COLORS[$this->status] ?? 'gray';
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUSES[$this->status] ?? ucfirst($this->status);
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match($this->status) {
            'live'           => 'bg-emerald-500/15 text-emerald-400 border-emerald-500/30',
            'in_development' => 'bg-orange-500/15 text-orange-400 border-orange-500/30',
            'testing'        => 'bg-yellow-500/15 text-yellow-400 border-yellow-500/30',
            'published'      => 'bg-blue-500/15 text-blue-400 border-blue-500/30',
            'archived'       => 'bg-red-500/15 text-red-400 border-red-500/30',
            default          => 'bg-gray-500/15 text-gray-400 border-gray-500/30',
        };
    }

    /* ── Auto-slug ───────────────────────────────── */
    protected static function boot(): void
    {
        parent::boot();
        static::creating(function ($project) {
            if (empty($project->slug)) {
                $project->slug = Str::slug($project->title);
            }
        });
    }
}
