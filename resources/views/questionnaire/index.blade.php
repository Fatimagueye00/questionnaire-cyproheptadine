<!DOCTYPE html>

<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Questionnaire de pré-test</title>

<style>
    * {
        box-sizing: border-box;
    }

    body {
        font-family: Arial, sans-serif;
        background: #f5f7fa;
        margin: 0;
        padding: 40px 20px;
        color: #333;
    }

    .container {
        max-width: 850px;
        margin: auto;
        background: white;
        padding: 35px;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    }

    h1 {
        color: #1f2937;
        margin-bottom: 15px;
    }

    .intro {
        color: #555;
        line-height: 1.6;
        margin-bottom: 30px;
    }

    .question {
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 1px solid #eee;
    }

    .question-title {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 15px;
        line-height: 1.5;
    }

    .answer {
        margin: 12px 0;
    }

    label {
        cursor: pointer;
        line-height: 1.6;
    }

    input[type="radio"],
    input[type="checkbox"] {
        margin-right: 8px;
        transform: scale(1.1);
    }

    .other-input {
        display: none;
        margin-top: 10px;
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 15px;
    }

    button {
        background: #2563eb;
        color: white;
        border: none;
        padding: 13px 28px;
        border-radius: 8px;
        cursor: pointer;
        font-size: 16px;
    }

    button:hover {
        background: #1d4ed8;
    }

    .multiple-info {
        font-size: 14px;
        color: #666;
        font-weight: normal;
    }

    /* Sous-question de la question 14 */
    .sub-question {
        display: none;
        margin-top: 20px;
        margin-left: 20px;
        padding: 20px;
        background: #f8fafc;
        border-left: 4px solid #2563eb;
        border-radius: 8px;
    }

    .sub-question .question-title {
        font-size: 16px;
    }

    .required-note {
        color: #777;
        font-size: 13px;
    }
</style>


</head>

<body>

<div class="container">


<h1>QUESTIONNAIRE DE PRÉ-TEST</h1>

<div class="intro">

    <p>
        Enquête auprès des pharmaciens d'officine afin d'évaluer
        les caractéristiques des demandes, le profil des consommateurs
        et les pratiques professionnelles face à ce phénomène.
    </p>

    <p>
        Les informations recueillies sont anonymes et confidentielles
        et seront utilisées exclusivement à des fins scientifiques.
    </p>

    <p>
        Nous vous remercions pour votre participation.
    </p>

</div>

<form method="POST" action="{{ route('questionnaire.submit') }}">


    @csrf

    @foreach ($questions as $question)

        <div class="question">

            {{-- NUMÉRO ET TEXTE DE LA QUESTION --}}
            <div class="question-title">

                {{ $loop->iteration }}.
                {{ $question->question }}

                @if ($question->type === 'multiple_choice')
                    <span class="multiple-info">
                        (Plusieurs réponses possibles)
                    </span>
                @endif

            </div>


            {{-- RÉPONSES DE LA QUESTION --}}
            @foreach ($question->answers->where('active', true) as $answer)

                <div class="answer">

                    <label>

                        @if ($question->type === 'multiple_choice')

                            <input
                                type="checkbox"
                                name="question_{{ $question->id }}[]"
                                value="{{ $answer->id }}"
                                data-question-id="{{ $question->id }}"
                                data-allows-other="{{ $answer->allows_other ? '1' : '0' }}"
                                onchange="toggleOther(this)"
                            >

                        @else

                            <input
                                type="radio"
                                name="question_{{ $question->id }}"
                                value="{{ $answer->id }}"
                                data-question-id="{{ $question->id }}"
                                data-allows-other="{{ $answer->allows_other ? '1' : '0' }}"
                                onchange="toggleOther(this); toggleQuestion14(this)"
                            >

                        @endif

                        {{ $answer->answer }}

                    </label>


                    {{-- CHAMP "AUTRE" --}}
                    @if ($answer->allows_other)

                        <input
                            type="text"
                            name="other_{{ $question->id }}"
                            id="other_{{ $answer->id }}"
                            class="other-input"
                            placeholder="Veuillez préciser..."
                        >

                    @endif

                </div>

            @endforeach


            {{-- ================================================= --}}
            {{-- SOUS-QUESTION DE LA QUESTION 14 UNIQUEMENT --}}
            {{-- ================================================= --}}

            @if ($question->order == 14)

                <div id="sous-question-14" class="sub-question">

                    <div class="question-title">

                        Si oui, pour quelle(s) raison(s) ?

                        <span class="multiple-info">
                            (Plusieurs réponses possibles)
                        </span>

                    </div>


                    <div class="answer">
                        <label>
                            <input
                                type="checkbox"
                                name="question_14_raisons[]"
                                value="absence_prescription"
                            >
                            Absence de prescription
                        </label>
                    </div>


                    <div class="answer">
                        <label>
                            <input
                                type="checkbox"
                                name="question_14_raisons[]"
                                value="utilisation_esthetique"
                            >
                            Utilisation à visée esthétique
                        </label>
                    </div>


                    <div class="answer">
                        <label>
                            <input
                                type="checkbox"
                                name="question_14_raisons[]"
                                value="posologie_inappropriee"
                            >
                            Posologie inappropriée
                        </label>
                    </div>


                    <div class="answer">
                        <label>
                            <input
                                type="checkbox"
                                name="question_14_raisons[]"
                                value="utilisation_prolongee"
                            >
                            Utilisation prolongée
                        </label>
                    </div>


                    <div class="answer">
                        <label>
                            <input
                                type="checkbox"
                                name="question_14_raisons[]"
                                value="demande_excessive"
                            >
                            Demande excessive/répétée
                        </label>
                    </div>


                    <div class="answer">

                        <label>
                            <input
                                type="checkbox"
                                name="question_14_raisons[]"
                                value="autre"
                                onchange="toggleAutre14(this)"
                            >
                            Autre
                        </label>

                        <input
                            type="text"
                            name="question_14_autre"
                            id="question_14_autre"
                            class="other-input"
                            placeholder="Veuillez préciser..."
                        >

                    </div>

                </div>

            @endif

        </div>

    @endforeach


    <button type="submit">
        Envoyer
    </button>

</form>

</div>

<script>

/*
|--------------------------------------------------------------------------
| CHAMP "AUTRE"
|--------------------------------------------------------------------------
*/

function toggleOther(input) {

    const questionId = input.dataset.questionId;

    const otherInputs = document.querySelectorAll(
        '[name="other_' + questionId + '"]'
    );

    /*
    | Pour les boutons radio :
    | on cache tous les champs "Autre" avant d'afficher
    | celui correspondant à la réponse sélectionnée.
    */

    if (input.type === 'radio') {

        otherInputs.forEach(function(otherInput) {

            otherInput.style.display = 'none';
            otherInput.value = '';

        });

    }


    const otherInput = document.getElementById(
        'other_' + input.value
    );


    if (!otherInput) {
        return;
    }


    if (
        input.checked &&
        input.dataset.allowsOther === '1'
    ) {

        otherInput.style.display = 'block';

        otherInput.focus();

    } else {

        otherInput.style.display = 'none';

        otherInput.value = '';

    }

}


/*
|--------------------------------------------------------------------------
| SOUS-QUESTION DE LA QUESTION 14
|--------------------------------------------------------------------------
|
| La sous-question apparaît uniquement lorsque la réponse
| "Oui" de la question 14 est sélectionnée.
|
*/

function toggleQuestion14(input) {

    const sousQuestion = document.getElementById(
        'sous-question-14'
    );


    if (!sousQuestion) {
        return;
    }


    /*
    | On vérifie que nous sommes bien sur la question 14.
    */

    if (input.dataset.questionId != "{{ $questions->firstWhere('order', 14)->id ?? '' }}") {
        return;
    }


    /*
    | Récupération du texte de la réponse.
    */

    const labelText = input.parentElement.textContent
        .trim()
        .toLowerCase();


    /*
    | Si la réponse contient "oui", on affiche
    | la sous-question.
    */

    if (
        input.checked &&
        labelText.includes('oui')
    ) {

        sousQuestion.style.display = 'block';

    } else {

        sousQuestion.style.display = 'none';


        /*
        | On décoche les raisons.
        */

        sousQuestion
            .querySelectorAll('input[type="checkbox"]')
            .forEach(function(checkbox) {

                checkbox.checked = false;

            });


        /*
        | On vide le champ Autre.
        */

        const autre = document.getElementById(
            'question_14_autre'
        );


        if (autre) {

            autre.style.display = 'none';

            autre.value = '';

        }

    }

}


/*
|--------------------------------------------------------------------------
| AUTRE DE LA SOUS-QUESTION 14
|--------------------------------------------------------------------------
*/

function toggleAutre14(input) {

    const autre = document.getElementById(
        'question_14_autre'
    );


    if (!autre) {
        return;
    }


    if (input.checked) {

        autre.style.display = 'block';

        autre.focus();

    } else {

        autre.style.display = 'none';

        autre.value = '';

    }

}

</script>

</body>
</html>