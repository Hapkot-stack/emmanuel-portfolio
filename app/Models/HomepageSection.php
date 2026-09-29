<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HomepageSection extends Model
{
    protected $fillable = [
        'section_key',
        'label',
        'draft',
        'published',
        'version',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'draft' => 'array',
            'published' => 'array',
            'published_at' => 'datetime',
        ];
    }

    public function versions(): HasMany
    {
        return $this->hasMany(HomepageSectionVersion::class);
    }

    public function hasPendingChanges(): bool
    {
        return $this->draft !== $this->published;
    }
}
