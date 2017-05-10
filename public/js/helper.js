

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
