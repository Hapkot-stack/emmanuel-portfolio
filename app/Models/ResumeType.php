<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ResumeType extends Model
{
    protected $fillable = ['type_key', 'template', 'sort_order', 'draft', 'published', 'version', 'published_at'];

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
        return $this->hasMany(ResumeTypeVersion::class);
    }

    public function hasPendingChanges(): bool
    {
        return $this->draft !== $this->published;
    }
}
