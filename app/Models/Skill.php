<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $fillable = ['name','category','proficiency','icon','color','badge_label','sort_order','featured'];
    protected $casts    = ['featured' => 'boolean'];

    public static function categories(): array
    {
        return ['technical','design','tool','soft'];
    }

    public static function categoryLabels(): array
    {
        return [
            'technical' => 'Backend & Technical',
            'design'    => 'Design & Frontend',
            'tool'      => 'Tools & Platforms',
            'soft'      => 'Professional Skills',
        ];
    }

    public static function categoryIcons(): array
    {
        return [
            'technical' => '⚙️',
            'design'    => '🎨',
            'tool'      => '🔧',
            'soft'      => '🤝',
        ];
    }
}
