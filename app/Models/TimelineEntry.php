<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimelineEntry extends Model
{
    protected $fillable = ['year','title','description','type','icon','color','sort_order'];

    const TYPE_COLORS = [
        'milestone'   => 'from-blue-500 to-cyan-400',
        'education'   => 'from-violet-500 to-purple-400',
        'work'        => 'from-emerald-500 to-teal-400',
        'project'     => 'from-orange-500 to-amber-400',
        'achievement' => 'from-pink-500 to-rose-400',
    ];

    public function getGradientAttribute(): string
    {
        return self::TYPE_COLORS[$this->type] ?? 'from-blue-500 to-cyan-400';
    }
}
