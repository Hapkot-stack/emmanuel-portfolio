<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    protected $table    = 'certificates';
    protected $fillable = ['title','issuer','year','image','credential_url','sort_order'];
}
