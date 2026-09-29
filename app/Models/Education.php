<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    protected $table    = 'educations';
    protected $fillable = ['degree','institution','location','period','description','sort_order'];
}
