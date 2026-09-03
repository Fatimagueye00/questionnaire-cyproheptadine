<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuestionnaireController;
Route::get('/', function () {
    return redirect()->route('questionnaire');
});
Route::get('/questionnaire', [QuestionnaireController::class, 'index'])
    ->name('questionnaire');
Route::post('/questionnaire', [QuestionnaireController::class, 'submit'])
    ->name('questionnaire.submit');
// Page pour consulter les réponses enregistrées
Route::get('/reponses', [QuestionnaireController::class, 'responses'])
    ->name('questionnaire.responses');