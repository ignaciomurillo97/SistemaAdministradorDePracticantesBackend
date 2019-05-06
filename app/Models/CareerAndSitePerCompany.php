<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CareerAndSitePerCompany extends Model
{
    protected $fillable = [
        'career_id', 'site_id', 'company_id', 'status'
    ];
}
