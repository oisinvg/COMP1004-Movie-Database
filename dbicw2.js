function validate(form)
{
    var msg=""
    for(var i=0; i < form.length-1; i++) { //-1 to ignore submit button
        if(form.elements[i].value.trim() == "") {
            msg += "'" + form.elements[i].name + "' is empty. "
        }
    }
    if(msg !== "") {
        alert(msg)
        return false
    }
    return true //If no problems return true
}