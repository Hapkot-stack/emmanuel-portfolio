<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialLink extends Model
{
    protected $fillable = ['platform','label','url','icon','color','sort_order','active'];
    protected $casts = ['active' => 'boolean'];
}
