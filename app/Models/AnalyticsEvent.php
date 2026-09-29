<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnalyticsEvent extends Model
{
    protected $fillable = [
        'event_type','page','label','ip_address','country','user_agent','referrer',
    ];

    public static function track(string $type, string $page = null, string $label = null): void
    {
        try {
            static::create([
                'event_type' => $type,
                'page'       => $page,
                'label'      => $label,
                'ip_address' => request()->ip(),
                'user_agent' => substr(request()->userAgent() ?? '', 0, 500),
                'referrer'   => substr(request()->header('referer') ?? '', 0, 500),
            ]);
        } catch (\Throwable) { /* fail silently */ }
    }
}
