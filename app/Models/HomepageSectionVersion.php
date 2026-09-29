<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HomepageSectionVersion extends Model
{
    protected $fillable = [
        'homepage_section_id',
        'version',
        'content',
        'published_by',
    ];

    protected function casts(): array
    {
        return ['content' => 'array'];
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(HomepageSection::class, 'homepage_section_id');
    }
}
