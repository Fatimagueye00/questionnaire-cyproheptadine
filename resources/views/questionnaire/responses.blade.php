<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réponses du questionnaire</title>
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            margin: 0;
            padding: 30px;
            font-family: Arial, sans-serif;
            background: #f5f7fa;
            color: #222;
        }
        .container {
            max-width: 1000px;
            margin: auto;
        }
        h1 {
            text-align: center;
            margin-bottom: 30px;
        }
        .response {
            background: white;
            padding: 25px;
            margin-bottom: 25px;
            border-radius: 12px;
            box-shadow: 0 3px 12px rgba(0,0,0,0.08);
        }
        .response-header {
            font-weight: bold;
            font-size: 18px;
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 1px solid #ddd;
        }
        .question {
            margin-bottom: 18px;
            padding: 15px;
            background: #f8f9fb;
            border-radius: 8px;
        }
        .question-title {
            font-weight: bold;
            margin-bottom: 8px;
        }
        .answer {
            color: #333;
            padding-left: 10px;
        }
        .empty {
            text-align: center;
            background: white;
            padding: 30px;
            border-radius: 12px;
        }
        .back {
            display: inline-block;
            margin-bottom: 25px;
            text-decoration: none;
            padding: 10px 16px;
            border-radius: 8px;
            background: #333;
            color: white;
        }
    </style>
</head>
<body>
<div class="container">
    <a href="{{ route('questionnaire') }}" class="back">
        ← Retour au questionnaire
    </a>
    <h1>Réponses enregistrées</h1>
    @if($responses->count() > 0)
        @foreach($responses as $response)
            <div class="response">
                <div class="response-header">
                    Réponse n°{{ $loop->iteration }}
                    <br>
                    <small>
                        Envoyée le {{ $response->created_at->format('d/m/Y à H:i') }}
                    </small>
                </div>
                @php
                    $reponses = is_array($response->reponses)
                        ? $response->reponses
                        : json_decode($response->reponses, true);
                @endphp
                @if(is_array($reponses))
                    @foreach($reponses as $key => $value)
                        @if($key !== '_token')
                            <div class="question">
                                <div class="question-title">
                                    {{ $key }}
                                </div>
                                <div class="answer">
                                    @if(is_array($value))
                                        {{ implode(', ', $value) }}
                                    @else
                                        {{ $value }}
                                    @endif
                                </div>
                            </div>
                        @endif
                    @endforeach
                @endif
            </div>
        @endforeach
    @else
        <div class="empty">
            <h2>Aucune réponse enregistrée</h2>
            <p>Les réponses apparaîtront ici lorsqu'une personne aura rempli le questionnaire.</p>
        </div>
    @endif
</div>
</body>
</html>