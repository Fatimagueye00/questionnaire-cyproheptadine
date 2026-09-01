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
            padding: 30px;
            font-family: Arial, sans-serif;
            background: #f4f7f6;
            color: #222;
        }

        .container {
            max-width: 950px;
            margin: auto;
            background: white;
            padding: 35px;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            margin-bottom: 12px;
            color: #176b4d;
            font-size: 30px;
        }

        .subtitle {
            font-size: 17px;
            line-height: 1.6;
            font-weight: 600;
        }

        .intro {
            margin-top: 20px;
            line-height: 1.7;
            color: #555;
        }

        .participant-header {
            display: none;
            margin: 20px 0;
            padding: 15px;
            background: #eef8f3;
            border-left: 5px solid #176b4d;
            border-radius: 8px;
        }

        .participant-header strong {
            color: #176b4d;
        }

        .participant-info {
            margin: 30px 0;
            padding: 25px;
            background: #f8faf9;
            border-radius: 12px;
        }

        .participant-info h2 {
            color: #176b4d;
            margin-top: 0;
        }

        .field {
            margin-bottom: 18px;
        }

        .field label {
            display: block;
            margin-bottom: 7px;
            font-weight: bold;
        }

        .field input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 7px;
            font-size: 15px;
        }

        .question {
            margin: 25px 0;
            padding: 22px;
            border: 1px solid #e0e0e0;
            border-radius: 12px;
            background: #fff;
        }

        .question-title {
            font-weight: bold;
            font-size: 17px;
            margin-bottom: 15px;
        }

        .answer {
            margin: 10px 0;
        }

        .answer label {
            cursor: pointer;
        }

        .other-input {
            display: none;
            margin-top: 10px;
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 7px;
        }

        .buttons {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 35px;
        }

        .btn {
            border: none;
            padding: 13px 30px;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
        }

        .btn-submit {
            background: #176b4d;
            color: white;
        }

        .btn-submit:hover {
            background: #12543c;
        }

        .btn-reset {
            background: #e5e5e5;
            color: #333;
        }

        .btn-reset:hover {
            background: #d2d2d2;
        }

        .success {
            padding: 15px;
            margin-bottom: 20px;
            background: #dff5e9;
            color: #176b4d;
            border-radius: 8px;
            font-weight: bold;
        }
    </style>
</head>

<body>

<div class="container">

    <div class="header">

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

    </div>


    {{-- Informations visibles dans l'entête --}}
    <div id="participantHeader" class="participant-header">

        <strong>Participant :</strong>

        <span id="headerNom"></span>
        <span id="headerPrenom"></span>

        <span id="headerAge"></span>
        <span id="headerFonction"></span>

    </div>


    @if(session('success'))
        <div class="success">
            {{ session('success') }}
        </div>
    @endif


    <form method="POST" action="{{ route('questionnaire.submit') }}">

        @csrf


        {{-- Informations du participant --}}
        <div class="participant-info">

            <h2>Informations du participant</h2>

            <div class="field">
                <label for="nom">Nom</label>
                <input
                    type="text"
                    id="nom"
                    name="nom"
                    required
                >
            </div>

            <div class="field">
                <label for="prenom">Prénom</label>
                <input
                    type="text"
                    id="prenom"
                    name="prenom"
                    required
                >
            </div>

            <div class="field">
                <label for="age">Âge</label>
                <input
                    type="number"
                    id="age"
                    name="age"
                    min="1"
                    max="120"
                    required
                >
            </div>

            <div class="field">
                <label for="fonction">Fonction</label>
                <input
                    type="text"
                    id="fonction"
                    name="fonction"
                    required
                >
            </div>

        </div>


        {{-- Questions --}}
        @foreach ($questions as $question)

            <div class="question">

                <div class="question-title">

                    {{ $question->order }}.
                    {{ $question->text }}

                    @if($question->multiple)
                        <small>
                            (Plusieurs réponses possibles)
                        </small>
                    @endif

                </div>


                @foreach ($question->answers as $answer)

                    <div class="answer">

                        @if($question->multiple)

                            <label>
                                <input
                                    type="checkbox"
                                    name="question_{{ $question->id }}[]"
                                    value="{{ $answer->id }}"
                                    onchange="toggleOther(this)"
                                >

                                {{ $answer->text }}
                            </label>

                        @else

                            <label>
                                <input
                                    type="radio"
                                    name="question_{{ $question->id }}"
                                    value="{{ $answer->id }}"
                                    onchange="toggleOther(this)"
                                    required
                                >

                                {{ $answer->text }}
                            </label>

                        @endif


                        @if(strtolower(trim($answer->text)) === 'autre')

                            <input
                                type="text"
                                name="other_{{ $question->id }}"
                                class="other-input"
                                placeholder="Précisez..."
                            >

                        @endif

                    </div>

                @endforeach

            </div>

        @endforeach


        {{-- UN SEUL bouton Envoyer --}}
        <div class="buttons">

            <button type="submit" class="btn btn-submit">
                Envoyer
            </button>

            <button type="reset" class="btn btn-reset">
                Effacer le formulaire
            </button>

        </div>

    </form>

</div>


<script>

    /*
     * Affichage automatique des informations
     * du participant dans l'entête.
     */

    const nomInput = document.getElementById('nom');
    const prenomInput = document.getElementById('prenom');
    const ageInput = document.getElementById('age');
    const fonctionInput = document.getElementById('fonction');

    const participantHeader =
        document.getElementById('participantHeader');

    const headerNom =
        document.getElementById('headerNom');

    const headerPrenom =
        document.getElementById('headerPrenom');

    const headerAge =
        document.getElementById('headerAge');

    const headerFonction =
        document.getElementById('headerFonction');


    function updateParticipantHeader() {

        headerNom.textContent =
            nomInput.value ? nomInput.value + ' ' : '';

        headerPrenom.textContent =
            prenomInput.value ? prenomInput.value + ' ' : '';

        headerAge.textContent =
            ageInput.value ? '(' + ageInput.value + ' ans) ' : '';

        headerFonction.textContent =
            fonctionInput.value
                ? '- ' + fonctionInput.value
                : '';

        participantHeader.style.display =
            (
                nomInput.value ||
                prenomInput.value ||
                ageInput.value ||
                fonctionInput.value
            )
            ? 'block'
            : 'none';
    }


    nomInput.addEventListener(
        'input',
        updateParticipantHeader
    );

    prenomInput.addEventListener(
        'input',
        updateParticipantHeader
    );

    ageInput.addEventListener(
        'input',
        updateParticipantHeader
    );

    fonctionInput.addEventListener(
        'input',
        updateParticipantHeader
    );


    /*
     * Afficher le champ "Autre"
     * uniquement lorsqu'il est sélectionné.
     */

    function toggleOther(element) {

        const parent =
            element.closest('.answer');

        const otherInput =
            parent.querySelector('.other-input');

        if (!otherInput) {
            return;
        }

        otherInput.style.display =
            element.checked
                ? 'block'
                : 'none';

    }

</script>

</body>
</html>