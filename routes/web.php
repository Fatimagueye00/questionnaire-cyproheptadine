```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuestionnaireController;

Route::get('/', function () {
    return redirect()->route('questionnaire');
});

Route::get('/questionnaire', [QuestionnaireController::class, 'index'])
    ->name('questionnaire');
