<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gender;
use App\Models\Scope;
use App\Models\Semester;

class CatalogController extends Controller
{
    public function getGender() {
        return Gender::all();
    }

    public function getScope() {
        return Scope::all();
    }

    public function getSemester() {
        return Semester::all();
    }
}
