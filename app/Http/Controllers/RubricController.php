<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rubric;

class RubricController extends Controller
{
    public function displayRubric()
    {
    	$rubric = Rubric::find(1);
    	return response()->json(['data' => json_decode($rubric->json_rubric), 'error' => NULL]);
    }

}
