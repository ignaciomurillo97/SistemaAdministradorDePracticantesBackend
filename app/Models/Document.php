<?php

namespace App;
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $table = 'files_per_person';
    protected $fillable = ['person_id','name','grade'];
}
