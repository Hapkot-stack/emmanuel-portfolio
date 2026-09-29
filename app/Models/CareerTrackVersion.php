<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CareerTrackVersion extends Model
{
    protected $fillable = ['career_track_id', 'version', 'content', 'published_by'];

    protected function casts(): array
    {
        return ['content' => 'array'];
    }

    public function careerTrack(): BelongsTo
    {
        return $this->belongsTo(CareerTrack::class);
    }
}
