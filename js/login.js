
function checkInputs(){
    let username_value = document.getElementById('username').value;
    let password_value = document.getElementById('password').value;
    let username_msg   = document.getElementById('username_error');
    let password_msg   = document.getElementById('password_error');

    let x = check_username(username_value,username_msg);
    if(x){
        x = check_password(password_value,password_msg);
        return x;
    }
    return x;
}

function check_username(username_value, username_msg){
    
    let username_pattern =/^[a-zA-Z][a-zA-Z0-9]*@[a-zA-Z]+\.[a-zA-Z]{2,4}$/;

    if(username_value === null || username_value === undefined || username_value.trim() === '' ){
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
    
    if(password_value === null || password_value === undefined || password_value.trim() === '' ){
        password_msg.textContent = "please enter your password";
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