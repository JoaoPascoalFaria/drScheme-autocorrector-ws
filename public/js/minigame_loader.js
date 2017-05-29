
var form = $("#minigame");
var minigame = null;
var initialTime = null;

function loadMinigame(json) {

    var minigameConf = Object.assign( {}, json );
    delete minigameConf.questions;

    if(minigame != null){
        minigame.finishExam();
    }
    minigame = new Minigame(minigameConf);

    json.questions.forEach( function (questionConf, i1) {

        minigame.addQuestion(questionConf);
    });

    form.append($.parseHTML("<button type='button' onclick='testMinigame()'>Test Exam</button>"));
    form.append($.parseHTML("<button type='button' onclick='submitMinigame()'>End Exam</button>"));

    initialTime = Date.now();
    $("body").append($.parseHTML("<div style='position: fixed; top: 15px; left: 15px; width: 250px; height: 40px; background-color: #BADA55; border: 1px solid #374f27; border-radius: 15px;' id='chronometer'></div>div>"));
    window.setInterval(function () {
        $("#chronometer").html($.parseHTML("<p style='text-align: center; font-size: 30px; padding: 5px;'>"+timelapseToTime(Date.now()-initialTime)+"</p>"));
    }, 1000);
}

function Minigame(config) {

    var _this=this;
    $.each( config, function (key, value) {
      _this[key] = value;
    });

    this.questions = [];

    // DOM Element creation
    this.domElement = $.parseHTML("<h3>"+this.displayed_game_name+"</h3><h4>"+this.game_description+"</h4>");
    form.append(this.domElement);

    // function belonging to the object, can access instantiated functions!
    this.finishExam = function() {

        var finalTime = Date.now();
        //var json = _this.serialize();
        var response = "";

        for( var i = 1; i<qID; i++) {
            var editor = ace.edit("question-"+i);
            response += "\n"+editor.getValue();
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type : "POST",
            url : "/api/evaluate",
            data : {
                id : _this.game_id,
                student : _this.user_token,
                response : response
            }
        }).done(function( eval ) {
            if ($.isNumeric(eval)) {
                $.ajax({
                    type: "POST",
                    url: "/api/saveResult",
                    data: {
                        user: _this.user_token,
                        exam: _this.game_id,
                        grade: eval,
                        submission: response,
                        timelapse: finalTime-initialTime
                    }
                }).done(function (data) {
                    console.log(data);
                    window.location.replace('/acknowledgement');
                });
            }
            else {
                console.log(eval);
            }
        });

        _this.delete();
        $("#minigame").html("<h3 style='text-align: center;'> Submitting exam, please wait. </h3>");
    };
    
    this.testSolution = function () {

        var response = "";
        for( var i = 1; i<qID; i++) {
            var editor = ace.edit("question-"+i);
            response += "\n"+editor.getValue();
        }

        //$("#myModal").modal('show');
        $("#myModal").modal({
            backdrop: 'static',
            keyboard: false
        });
        $("#myModal p").html("Please wait..");
        $("#myModal button").get(0).classList.add("disabled");
        $("#myModal button").get(0).disabled = true;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type : "POST",
            url : "/api/evaluate",
            data : {
                id : _this.game_id,
                student : _this.user_token,
                response : response
            }
        }).done(function( eval ) {

            var msg;
            if( eval < 100) {
                msg = "The answer is incorrect";
            }
            else
                msg = "The answer is correct";

            $("#myModal p").html(msg);
            $("#myModal button").get(0).classList.remove("disabled");
            $("#myModal button").get(0).disabled = false;
        });
    }
}

// functions shared by all Minigames, doesn't know constructor fields (prototypes)
Minigame.prototype.addQuestion = function (config) {

    var q = new Question(config);
    this.questions.push(q);
    form.append(q.domElement);
};

Minigame.prototype.serialize = function () {

    var result = "{\n";
    $.each(this, function (key, value) {
        if( value instanceof Array) {
            result += "\""+key+"\": [\n";
            value.forEach( function (question, index) {
                result += question.serialize();
                if(index < value.length -1)
                    result += ",\n";
                else
                    result += "\n";
            });
            result += "]";
        }
        else if( value instanceof Function){
            return;
        }
        else {
            result += "\"" + key + "\": \"" + value + "\"";
        }

        result += ",\n";
    });
    result = result.substr(0,result.length-2); result += '\n'; // remove extra comma
    result += "}";

    return tabify(result);
};

Minigame.prototype.delete = function () {

    this.questions.forEach( function (question, index) {
        question.delete();
    });
    $(this.domElement).remove();
    minigame = null;
};

// static function, not linked to a particular instance
Minigame.getConfiguration = function () {
    return {
        "game_id": "",
        "displayed_game_name": "",
        "lang": "",
        "game_description": "",
        "user_token": "",
        "timeout": "",
        "pausable": "",
        "accessible": ""
    };
};

var qID = 0;
function Question(config) {

    var _this=this;
    $.each( config, function (key, value) {
        _this[key] = value;
    });

    this.id = qID++;

    // DOM Element creation
    this.domElement = document.createElement("div");
    this.domElement.classList.add("form-group");

    var label = document.createElement("label");
    label.setAttribute("for", this.id);
    label.innerHTML = this.question_text;
    this.domElement.appendChild(label);

    var input = document.createElement("div");
    //input.classList.add("form-control");
    input.classList.add("ace-editor");
    input.classList.add("textarea");
    input.setAttribute("id", "question-"+this.id);
    //input.setAttribute("rows", "25");
    input.setAttribute("data-mode", this.lang);
    input.setAttribute("data-theme", "chrome");
    input.innerHTML = this.answer_text_template;
    this.domElement.appendChild(input);
}

Question.prototype.serialize = function () {

    var result = "{\n";
    $.each(this, function (key, value) {
            result += "\"" + key + "\": \"" + value + "\",\n";
    });
    result = result.substr(0,result.length-2); result += '\n'; // remove extra comma
    result += "}";

    return result;
};

Question.prototype.delete = function () {

    $(this.domElement).remove();
};

Question.getConfiguration = function () {
    return {
        "question_text": "",
        "question_image_url": "",
        "skippable": "",
        "timeout": "",
        "lang": "",
        "answer_text_template": ""
    };
};

function testMinigame() {
    minigame.testSolution();
}

function submitMinigame() {
    if (confirm("Finish Exam?"))
        minigame.finishExam();
}