<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectScreenshot extends Model
{
    protected $fillable = ['project_id','image','caption','device_type','sort_order'];

    public function project(): BelongsTo { return $this->belongsTo(Project::class); }

    public function getImageUrlAttribute(): string
    {
        if (str_starts_with($this->image, 'screenshots/')) {
            return asset('storage/'.$this->image);
        }
        return asset($this->image);
    }
}
