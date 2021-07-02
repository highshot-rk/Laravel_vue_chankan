<?php

namespace App\Http\Controllers\Client;

use App\Survey;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SurveysController extends Controller
{
    public function show($id)
    {
        $survey = Survey::find($id);
        return view('progress.surveyShow', compact('survey'));
    }
}
