function checkInputs(){
    let first_name_value = document.getElementById('first_name').value;
    let last_name_value  = document.getElementById('last_name').value;
    let username_value   = document.getElementById('username').value;
    let password_value   = document.getElementById('password').value;
    let first_name_msg   = document.getElementById('first_name_error');
    let last_name_msg    = document.getElementById('last_name_error');
    let username_msg     = document.getElementById('username_error');
    let password_msg     = document.getElementById('password_error');

    let check = check_first_name(first_name_value,first_name_msg);
    if(check){
        check = check_last_name(last_name_value,last_name_msg);
        if(check){
            check = check_username(username_value,username_msg);
            if(check){
                check = check_password(password_value,password_msg);
                return check;
            }
        }
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

function check_username(username_value, username_msg){
    
    let username_pattern =/^[a-zA-Z0-9]+@[a-zA-Z]+\.[a-zA-Z]{2,4}$/;

    if(username_value === null || username_value === undefined || username_value === '' ){
        username_msg.textContent = "please enter your username";
        return false;
    }
    if(!username_pattern.test(username_value)){
        username_msg.textContent = "please enter a valid username";
        return false;
    }
    username_msg.textContent = "";
    return true;
}
    

function check_password(password_value,password_msg){
    if(password_value === null || password_value === undefined || password_value === '' ){
        password_msg.textContent = "please enter your password";
        return false;
    }

    if(password_value.length < 8){
        password_msg.textContent = "Your password must be at least 8 characters";
        return false;
    }

    password_msg.textContent = "";
    return true;
}

function toggle_password(password_field_id, password_icon_id){
    let password_field = document.getElementById(password_field_id);
    let password_icon  = document.getElementById(password_icon_id);

    if(password_field.type == "password"){
        password_field.type = "text";
    }
    else{
        password_field.type = "password";
    }
    password_icon.classList.toggle("fa-eye-slash");   
    password_icon.classList.toggle("fa-eye");   
}

    
   