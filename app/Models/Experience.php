<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    protected $table    = 'experiences';
    protected $fillable = ['title','company','location','period','description','type','current','sort_order'];
    protected $casts    = ['current' => 'boolean'];
}
