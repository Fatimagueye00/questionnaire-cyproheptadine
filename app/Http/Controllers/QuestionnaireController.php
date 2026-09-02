<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\QuestionnaireResponse;
use Illuminate\Http\Request;

class QuestionnaireController extends Controller
{
    public function index()
    {
        $questions = Question::with([
            'answers' => function ($query) {
                $query->orderBy('order', 'asc');
            }
        ])
        ->where('active', true)
        ->orderBy('order', 'asc')
        ->get();

        foreach ($questions as $question) {
            $question->setRelation(
                'answers',
                $question->answers->unique('id')->values()
            );
        }

        return view('questionnaire.index', compact('questions'));
    }

    public function submit(Request $request)
    {
        $reponses = $request->except([
            '_token',
        ]);

        QuestionnaireResponse::create([
            'reponses' => $reponses,
        ]);

        return redirect()
            ->route('questionnaire')
            ->with(
                'success',
                'Votre questionnaire a été envoyé avec succès.'
            );
    }
}