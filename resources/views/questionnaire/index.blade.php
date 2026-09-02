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
            margin: 0;
            padding: 30px 15px;
            background: #f5f7fb;
            font-family: Arial, sans-serif;
            color: #222;
        }

        .container {
            max-width: 900px;
            margin: auto;
            background: white;
            padding: 35px;
            border-radius: 15px;
            box-shadow: 0 5px 25px rgba(0,0,0,0.08);
        }

        h1 {
            text-align: center;
            margin-bottom: 10px;
            color: #222;
        }

        .subtitle {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            line-height: 1.5;
            margin-bottom: 25px;
        }

        .intro {
            line-height: 1.7;
            text-align: justify;
            margin-bottom: 30px;
        }

        .question {
            margin-bottom: 30px;
            padding: 22px;
            border: 1px solid #e3e6eb;
            border-radius: 12px;
            background: #fafbfc;
        }

        .question-title {
            font-size: 17px;
            font-weight: bold;
            margin-bottom: 15px;
            line-height: 1.5;
        }

        .multiple-info {
            display: inline-block;
            font-size: 13px;
            font-weight: normal;
            color: #666;
            margin-left: 5px;
        }

        .answer {
            margin: 10px 0;
        }

        .answer label {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            line-height: 1.5;
        }

        input[type="radio"],
        input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
            flex-shrink: 0;
        }

        .other-input {
            display: none;
            width: 100%;
            margin-top: 8px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        .buttons {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }

        button {
            flex: 1;
            padding: 14px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
        }

        .submit-btn {
            background: #198754;
            color: white;
        }

        .reset-btn {
            background: #6c757d;
            color: white;
        }

        .success {
            padding: 15px;
            background: #d1e7dd;
            color: #0f5132;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .error {
            padding: 15px;
            background: #f8d7da;
            color: #842029;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .sub-question {
            display: none;
            margin-top: 20px;
            padding: 15px;
            background: #fff;
            border-left: 4px solid #198754;
            border-radius: 8px;
        }

        .sub-question-title {
            font-weight: bold;
            margin-bottom: 10px;
        }

        .no-questions {
            text-align: center;
            padding: 30px;
            color: #777;
        }

        @media (max-width: 600px) {
            body {
                padding: 10px;
            }

            .container {
                padding: 20px 15px;
            }

            .buttons {
                flex-direction: column;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <h1>QUESTIONNAIRE DE PRÉ-TEST</h1>

    <div class="subtitle">
        Pré-test du questionnaire d’enquête sur le mésusage de la cyproheptadine
        à des fins orexigènes auprès des pharmaciens d’officine
    </div>

    <div class="intro">
        <p>
            Dans le cadre d’une étude portant sur le mésusage de la cyproheptadine
            à des fins orexigènes, nous réalisons une enquête auprès des pharmaciens
            d’officine afin d’évaluer les caractéristiques des demandes, le profil
            des consommateurs ainsi que les pratiques et le niveau de vigilance
            des professionnels face à ce phénomène.
        </p>

        <p>
            Les informations recueillies sont anonymes et confidentielles et seront
            utilisées exclusivement à des fins scientifiques.
        </p>

        <p>
            Nous vous remercions pour votre participation.
        </p>
    </div>

    @if(session('success'))
        <div class="success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="error">
            <strong>Veuillez corriger les erreurs suivantes :</strong>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('questionnaire.submit') }}">
        @csrf

        @if(isset($questions) && $questions->count() > 0)

            @foreach($questions as $question)

                <div class="question">

                    <div class="question-title">
                        {{ $question->order }}.
                        {{ $question->question }}

                        @if($question->type === 'multiple_choice')
                            <span class="multiple-info">
                                (Plusieurs réponses possibles)
                            </span>
                        @endif
                    </div>

                    @if($question->answers && $question->answers->count() > 0)

                        @foreach($question->answers as $answer)

                            <div class="answer">

                                @if($question->type === 'multiple_choice')

                                    <label>
                                        <input
                                            type="checkbox"
                                            name="question_{{ $question->id }}[]"
                                            value="{{ $answer->id }}"
                                            onchange="toggleOther(this)"
                                        >

                                        <span>{{ $answer->answer }}</span>
                                    </label>

                                @else

                                    <label>
                                        <input
                                            type="radio"
                                            name="question_{{ $question->id }}"
                                            value="{{ $answer->id }}"
                                            onchange="toggleOther(this); toggleQuestion14(this)"
                                            required
                                            data-question-id="{{ $question->id }}"
                                        >

                                        <span>{{ $answer->answer }}</span>
                                    </label>

                                @endif

                                @if($answer->allows_other)

                                    <input
                                        type="text"
                                        name="other_{{ $question->id }}"
                                        class="other-input"
                                        placeholder="Précisez..."
                                    >

                                @endif

                            </div>

                        @endforeach

                    @else

                        <p>Aucune réponse disponible pour cette question.</p>

                    @endif


                    {{-- Sous-question de la question 14 --}}
                    @if($question->order == 14)

                        <div id="sous-question-14" class="sub-question">

                            <div class="sub-question-title">
                                Si oui, pour quelle(s) raison(s) ?
                            </div>

                            <label>
                                <input
                                    type="checkbox"
                                    name="question_14_raisons[]"
                                    value="augmentation_appetit"
                                >
                                Augmentation de l’appétit
                            </label>
                            <br>

                            <label>
                                <input
                                    type="checkbox"
                                    name="question_14_raisons[]"
                                    value="prise_de_poids"
                                >
                                Recherche de prise de poids
                            </label>
                            <br>

                            <label>
                                <input
                                    type="checkbox"
                                    name="question_14_raisons[]"
                                    value="autre"
                                >
                                Autre
                            </label>

                            <input
                                type="text"
                                name="question_14_autre"
                                class="other-input"
                                placeholder="Précisez..."
                            >

                        </div>

                    @endif

                </div>

            @endforeach

        @else

            <div class="no-questions">
                Aucune question disponible pour le moment.
            </div>

        @endif


        <div class="buttons">

            <button type="submit" class="submit-btn">
                Envoyer
            </button>

            <button type="reset" class="reset-btn">
                Effacer le formulaire
            </button>

        </div>

    </form>

</div>


<script>

    function toggleOther(element) {

        const answerContainer = element.closest('.answer');

        if (!answerContainer) {
            return;
        }

        const otherInput = answerContainer.querySelector('.other-input');

        if (!otherInput) {
            return;
        }

        if (element.checked) {
            otherInput.style.display = 'block';
        } else {
            otherInput.style.display = 'none';
            otherInput.value = '';
        }
    }


    function toggleQuestion14(element) {

        const questionId = element.dataset.questionId;

        const questionNumber = "{{ $questions->firstWhere('order', 14)->id ?? '' }}";

        const sousQuestion = document.getElementById('sous-question-14');

        if (!sousQuestion) {
            return;
        }

        if (questionId != questionNumber) {
            return;
        }

        const label = element.closest('label');

        if (!label) {
            return;
        }

        const texte = label.innerText.toLowerCase();

        if (texte.includes('oui')) {
            sousQuestion.style.display = 'block';
        } else {
            sousQuestion.style.display = 'none';

            sousQuestion.querySelectorAll('input[type="checkbox"]')
                .forEach(input => input.checked = false);

            sousQuestion.querySelectorAll('input[type="text"]')
                .forEach(input => {
                    input.value = '';
                    input.style.display = 'none';
                });
        }
    }


    document.addEventListener('change', function(event) {

        if (
            event.target.matches(
                'input[name="question_14_raisons[]"]'
            )
        ) {

            const autreInput =
                document.querySelector(
                    'input[name="question_14_autre"]'
                );

            if (!autreInput) {
                return;
            }

            if (
                event.target.value === 'autre' &&
                event.target.checked
            ) {
                autreInput.style.display = 'block';
            }

            if (
                event.target.value === 'autre' &&
                !event.target.checked
            ) {
                autreInput.style.display = 'none';
                autreInput.value = '';
            }
        }

    });

</script>

</body>
</html>