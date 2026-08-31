<?php

namespace App\Http\Controllers;

use App\Models\Question;

class QuestionnaireController extends Controller
{
    public function index()
    {
        $questions = Question::with('answers')
            ->where('active', true)
            ->orderBy('order', 'asc')
            ->get();

        return view('questionnaire.index', compact('questions'));
    }
}