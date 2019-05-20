<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CareerAndSitePerCompany extends Model
{
    protected $fillable = [
        'career_id', 'site_id', 'company_id', 'status'
    ];

    public function Career() {
        return $this->belongsTo('App\Models\Career');
    }

    public function Site() {
        return $this->belongsTo('App\Models\Site');
    }

    public function Company() {
        return $this->belongsTo('App\Models\Company', 'company_id', 'legal_id');
    }
}
