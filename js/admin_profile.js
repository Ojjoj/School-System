function check_passwords(){
    let old_password_value     = document.getElementById('old_password').value;
    let new_password_value     = document.getElementById('new_password').value;
    let confirm_password_value = document.getElementById('confirm_password').value;
    let old_password_msg       = document.getElementById('old_password_error');
    let new_password_msg       = document.getElementById('new_password_error');
    let confirm_password_msg   = document.getElementById('confirm_password_error');
    let matching_password_msg  = document.getElementById('matching_password_error');

    let check = check_old_password(old_password_value,old_password_msg);
    if(check){
        check = check_new_password(new_password_value,new_password_msg);
        if(check){
            check= check_confirm_password(confirm_password_value, confirm_password_msg);
            if(check){
                check = compare_password(new_password_value, confirm_password_value, matching_password_msg);
            }
        }
        return check;
    }
    return check;
}

function check_old_password(old_password_value, old_password_msg){
    
    if(old_password_value === null || old_password_value === undefined || old_password_value === '' ){
        old_password_msg.textContent = "please enter your current password";
        return false;
    }
    old_password_msg.textContent = "";
    return true;
}

function check_new_password(new_password_value,new_password_msg){
    if(new_password_value === null || new_password_value === undefined || new_password_value === '' ){
        new_password_msg.textContent = "please enter your new password";
        return false;
    }
    new_password_msg.textContent = "";
    return true;
}

function check_confirm_password(confirm_password_value, confirm_password_msg){
    
    if(confirm_password_value === null || confirm_password_value === undefined || confirm_password_value === '' ){
        confirm_password_msg.textContent = "please re-enter your password";
        return false;
    }
    confirm_password_msg.textContent = "";
    return true;
}

function compare_password(new_password, confirm_password, matching_password_msg ){
    if(new_password !== confirm_password){
        matching_password_msg.textContent = "Passwords don't match. Please try again.";
        return false;
    }
    else{
        matching_password_msg.textContent = "";
        return true;
    }
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
