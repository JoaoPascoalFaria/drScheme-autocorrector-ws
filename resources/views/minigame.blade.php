
<!doctype html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Programming Minigame</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->

        <link href="../css/minigame.css" rel="stylesheet" type="text/css">

    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="content">
                <form id="minigame">

                </form>
            </div>
        </div>
    </body>
    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../../js/minigame_loader.js"></script>
</html>

<script>
    loadMinigame(
        {
            "displayed_game_name": "Programming",
            "lang": "en",
            "game_description": "Coding games for Dr.Scheme",
            "user_token": "",
            "timeout": "60",
            "pausable": "false",
            "accessible": "false",
            "questions": [
                {
                    "id": "1",
                    "question_text": "Faça um programa que some a sequência de Fibonacci nas primeiras 10 iterações.",
                    "question_image_url": "",
                    "skippable": "",
                    "timeout": "",
                    "answer_text_template": "Não sei o que é a sequência de Fibonacci"
                },{
                    "id": "2",
                    "question_text": "Programa que calcule o n-ésimo número primo.",
                    "question_image_url": "",
                    "skippable": "",
                    "timeout": "",
                    "answer_text_template": "nop"
                }
            ]
        }
    );
</script>