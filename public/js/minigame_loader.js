
var form = $("#minigame");
var minigame = null;

function loadMinigame(json) {

    var minigameConf = Object.assign( {}, json );
    delete minigameConf.questions;

    if(minigame != null){
        minigame.save();
    }
    minigame = new Minigame(minigameConf);

    json.questions.forEach( function (questionConf, i1) {

        minigame.addQuestion(questionConf);
    });

    form.append($.parseHTML("<button onclick='submitMinigame()'>Submit</button>"));
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
    this.save = function() {

        var json = _this.serialize();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type : "POST",
            url : "/saveminigameconf",
            data : {
                mgc : json
            }
        }).done(function( data ) {
            console.log(data);
        });

        _this.delete();
    };
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

function Question(config) {

    var _this=this;
    $.each( config, function (key, value) {
        _this[key] = value;
    });

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
    input.setAttribute("id", this.id);
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



function submitMinigame() {
    minigame.save();
}
