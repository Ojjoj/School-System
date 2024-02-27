function checkInputs(){
    let first_name_value = document.getElementById('first_name').value;
    let last_name_value  = document.getElementById('last_name').value;
    let first_name_msg   = document.getElementById('first_name_error');
    let last_name_msg    = document.getElementById('last_name_error');

    let check = check_first_name(first_name_value,first_name_msg);
    if(check){
        check = check_last_name(last_name_value,last_name_msg);
        return check;
    }
    return check;
}

function check_first_name(first_name_value,first_name_msg){
    if(first_name_value === null || first_name_value === undefined || first_name_value === '' ){
        first_name_msg.textContent = "please enter your first name";
        return false;
    }
    first_name_msg.textContent = "";
    return true;
}

function check_last_name(last_name_value,last_name_msg){
    if(last_name_value === null || last_name_value === undefined || last_name_value === '' ){
        last_name_msg.textContent = "please enter your last name";
        return false;
    }
    last_name_msg.textContent = "";
    return true;
}

    
   