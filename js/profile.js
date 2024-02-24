function check_input(){
    let first_name      = document.getElementById('first_name').value;
    let last_name       = document.getElementById('last_name').value;
    let warning         = document.getElementById('warning');
    let warning_message = document.getElementById('warning_message');

    let check = check_input_value(first_name, warning);
    if(check){
        check = check_input_value(last_name, warning);
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
    let warning          = document.getElementById('warning');
    let warning_message  = document.getElementById('warning_message');

   
    let check = check_input_value(current_password, warning);
    if(check){
        check = check_input_value(new_passsword, warning);
        if(check){
            check = check_input_value(confirm_password, warning);
            if(check){
                check = matching_password(new_passsword, confirm_password, warning);
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


function check_input_value(input_value, warning){
    if(input_value === null || input_value === undefined || input_value.trim() === ''){
        warning.style.display ='block';
        return false;
    }
    alert(input_value.length)
    warning.style.display ='none';
    return true;
}

function matching_password(new_passsword, confirm_password, warning_message){
    if(new_passsword !== confirm_password){
        warning_message.style.display = 'block';
        return false;
    }
    warning_message.style.display = 'none';
    return true;
}

function password_length(new_passsword){
    if(new_passsword.length<8){
        return false;
    }
    return true;
}
