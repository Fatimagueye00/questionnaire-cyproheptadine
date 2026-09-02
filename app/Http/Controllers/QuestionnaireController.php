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
        // Récupérer uniquement les réponses du questionnaire
        $reponses = $request->except([
            '_token',
        ]);
        // Enregistrer les réponses
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