
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
        <link href="/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="/css/minigame.css" rel="stylesheet" type="text/css">

    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="content">
                <form id="minigame">

                </form>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="myModal" role="dialog" style="display: none; margin: auto;">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" style="text-align: center;">Testing solution</h4>
                    </div>
                    <div class="modal-body">
                        <p style="text-align: center;">Please wait..</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default disabled" data-dismiss="modal" style="margin: 0 auto; display: block;">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </body>

    <!-- jQuery -->
    <script src="/vendor/jquery/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="/vendor/bootstrap/js/bootstrap.js"></script>

    <script src="/js/helper.js"></script>
    <script src="/js/minigame_loader.js"></script>
    <!-- Ace -->
    <script src="/assets/bower/ace-builds/src-min-noconflict/ace.js" charset="utf-8"></script>
    <!-- Ace-helper -->
    <script src="/assets/bower/ace-helper/src/ace-helper.js"></script>
</html>

<script>

    window.onload = function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type : "POST",
            url : "/api/getExam",
            data : {
                id : "<?php echo $exam; ?>"
            }
        }).done( function( data ) {
            data = JSON.parse(data);
            data.wording = JSON.parse(data.wording);
            data.wording.user_token = "<?php echo $student; ?>";
            loadMinigame( data.wording);
            AceHelper.init();
        });
    };/**/
    /*window.onload = function() {
    loadMinigame(
     {
     "game_id": "1",
     "displayed_game_name": "Programming",
     "lang": "en",
     "game_description": "Coding games for Dr.Scheme",
     "user_token": "up_3020123",
     "timeout": "60",
     "pausable": "false",
     "accessible": "false",
     "questions": [
     {
     "question_text": "Faça um programa que some a sequência de Fibonacci nas primeiras 10 iterações.",
     "question_image_url": "",
     "skippable": "",
     "timeout": "",
     "lang": "scheme",
     "answer_text_template": ""
     },{
     "question_text": "Programa que calcule todos os primos até ao número n.",
     "question_image_url": "",
     "skippable": "",
     "timeout": "",
     "lang": "scheme",
     "answer_text_template": "(define (isPrimeHelper x k)\n"+
     "(if (= x k)\n"+
     "#t                           \n"+
     "(if (= (remainder x k) 0)    \n"+
     "#f                               \n"+
     "(isPrimeHelper x (+ k 1)))))     \n"+
     "\n"+
     "(define (printPrimesUpTo n)\n"+
     "(define result '())\n"+
     "(define (helper x)\n"+
     "(if (= x (+ 1 n))\n"+
     "result                  \n"+
     "(if (isPrime x)         \n"+
     "(cons x result) ))         \n"+
     "( helper (+ x 1)))\n"+
     "( helper 1 ))"
     }
     ]
     }
     )};/**/
</script>