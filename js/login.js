// test if the input fields are filled or not by calling other functions
// it is triggered by onsubmit event
// if the return value = false it will stay in the same page
// if the return value = true it will go to home page
function checkInputs(){
    let username_value = document.getElementById('username').value;
    let password_value = document.getElementById('password').value;
    let username_msg = document.getElementById('username_error');
    let password_msg = document.getElementById('password_error');

    let x = check_username(username_value,username_msg);
    // test if the username field is filled then test the password field
    if(x){
        x = check_password(password_value,password_msg);
        return x;
    }
    return x;
}

// it tests the username field if it is empty or if it doesn't match the pattern
function check_username(username_value, username_msg){
    
    let username_pattern =/^[a-zA-Z][a-zA-Z0-9]*@[a-zA-Z]+\.[a-zA-Z]{2,4}$/;

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

// it tests the password field if it is empty
function check_password(password_value,password_msg){
    if(password_value === null || password_value === undefined || password_value === '' ){
        password_msg.textContent = "please enter your password";
        return false;
    }
    password_msg.textContent = "";
    return true;
}
