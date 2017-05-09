
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
}

function Minigame(config) {

    var _this=this;
    $.each( config, function (key, value) {
      _this[key] = value;
    });

    this.questions = [];

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
            //loadGraph("/samples/sv_graph.json");
        });

        minigame = null;
    };
}

// functions shared by all Minigames, doesn't know constructor fields (prototypes)
Minigame.prototype.addQuestion = function (config) {
    this.questions.push(new Question(config));
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
        else {
            result += "\"" + key + "\": \"" + value + "\"";
        }

        result += ",\n";
    });
    result = result.substr(0,result.length-2); result += '\n'; // remove extra comma
    result += "}";

    return tabify(result);
};

// static function, not linked to a particular instance
Minigame.getConfiguration = function () {
    return {
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

Question.getConfiguration = function () {
    return {
        "id": "",
        "question_text": "",
        "question_image_url": "",
        "skippable": "",
        "timeout": "",
        "answer_text_template": ""
    };
};



function tabify(str) {
    var result = "";
    var counter = 0;
    for( var i = 0; i < str.length; i++){
        var char = str.charAt(i);
        if(char == ']' || char =="}") {
            counter--;
            if(result.slice(-1) == '\t') {// avoid deleting [ when empty array
                result = result.slice(0,-1);// delete one tab
            }
        }
        result += char;
        if(char == '[' || char == '{') {
            counter++;
        }
        else if(char == '\n') {
            for( var j = 0; j < counter; j++) {
                result += '\t';
            }
        }
    }
    return result;
}