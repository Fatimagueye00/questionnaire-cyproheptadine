<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\QuestionnaireResponse;
use Illuminate\Http\Request;

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

    public function submit(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'age' => 'required|integer|min:1|max:120',
            'fonction' => 'required|string|max:255',
        ]);

        $reponses = $request->except([
            '_token',
            'nom',
            'prenom',
            'age',
            'fonction',
        ]);

        QuestionnaireResponse::create([
            'nom' => $validated['nom'],
            'prenom' => $validated['prenom'],
            'age' => $validated['age'],
            'fonction' => $validated['fonction'],
            'reponses' => $reponses,
        ]);

        return redirect()
            ->route('questionnaire')
            ->with('success', 'Votre questionnaire a été envoyé avec succès.');
    }
}