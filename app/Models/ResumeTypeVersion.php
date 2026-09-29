<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ResumeTypeVersion extends Model
{
    protected $fillable = ['resume_type_id', 'version', 'content', 'published_by'];

    protected function casts(): array
    {
        return ['content' => 'array'];
    }

    public function resumeType(): BelongsTo
    {
        return $this->belongsTo(ResumeType::class);
    }
}
