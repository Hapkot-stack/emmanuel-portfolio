<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CareerTrack extends Model
{
    protected $fillable = ['slug', 'draft', 'published', 'version', 'published_at'];

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
        return $this->hasMany(CareerTrackVersion::class);
    }

    public function hasPendingChanges(): bool
    {
        return $this->draft !== $this->published;
    }
}
