function check_input(){
    let first_name      = document.getElementById('first_name').value;
    let last_name       = document.getElementById('last_name').value;
    let warning_message = document.getElementById('warning_message');

    let check = check_input_value(first_name);
    if(check){
        check = check_input_value(last_name);
        if(!check){
            warning_message.textContent ='Please enter your last name';
        }
    }
    else{
        warning_message.textContent ='Please enter your first name';
    }
    return check;
}


function check_password(){
    let current_password = document.getElementById('current_password').value;
    let new_passsword    = document.getElementById('new_password').value;
    let confirm_password = document.getElementById('confirm_password').value;
   
    let check = check_input_value(current_password);
    if(check){
        check = check_input_value(new_passsword);
        if(check){
            check = check_input_value(confirm_password);
            if(check){
                check = matching_password(new_passsword, confirm_password);
                if(!check)
                warning_message.textContent ='Passwords don\'t match. Please try again';   
            }
            else
                warning_message.textContent ='Please confirm your password'; 
        }
        else
            warning_message.textContent ='Please enter your new password';
    }
    else
        warning_message.textContent ='Please enter your current password';
    return check;  
}


function check_input_value(input_value){
    let warning = document.getElementById('warning');
    if(input_value === null || input_value === undefined || input_value.trim() === ''){
        warning.classList.remove("d-none");
        return false;
    }
    warning.classList.add("d-none");
    return true;
}

function matching_password(new_passsword, confirm_password){
    let warning = document.getElementById('warning');
    if(new_passsword !== confirm_password){
        warning.classList.remove("d-none");
        return false;
    }
    warning.classList.add("d-none");
    return true;
}

function password_length(new_passsword){
    if(new_passsword.length<8){
        return false;
    }
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