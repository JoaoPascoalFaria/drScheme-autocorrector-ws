

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


function timelapseToTime (ms) {
    var x = Math.trunc(ms / 1000);
    var seconds = x % 60;
    x = Math.trunc( x/60);
    var minutes = x % 60;
    x = Math.trunc(x/60);
    var hours = x % 24;
    x = Math.trunc(x/24);
    var days = x;
    return (days>0?days+"d ":"")+(days>0||hours>0?hours+"h ":"")+(days>0||hours>0||minutes>0?minutes+"m ":"")+seconds+"s";
}