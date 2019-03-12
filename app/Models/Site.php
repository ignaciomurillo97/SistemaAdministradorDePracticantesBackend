<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    public function careers() {
        return $this->belongsToMany('App\Models\Career', 'careerPerSite');
    }
    
    protected $fillable = ['site'];
}
