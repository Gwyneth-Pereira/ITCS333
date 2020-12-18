// JS RegEx
var nameFlag=emailFlag=usernameFlag=passwordFlag=false;

function checkName(name){
    var nameExp=/^[a-zA-Z]{3,}(?:\s[a-zA-Z]{3,})+$/;
    if (name.length==0){
    m="";
    nameFlag=false;
    }
    else if (!nameExp.test(name)){
        m="Please enter your first and last name seperated by a space";
        c="red";
        nameFlag=false;
    }
    else{
        m="Valid Name";
        c="green";
        nameFlag=true;
    }
    document.getElementById('nmsg').style.color=c;
    document.getElementById('nmsg').innerHTML=m;
}

function checkEmail(email){
    var emailExp=/^[a-zA-Z0-9._-]+@[a-zA-Z0-9]+\.[a-zA-Z]{2,5}$/;
    if (email.length==0){
    m="";
    emailFlag=false;
    }
    else if (!emailExp.test(email)){
        m="Invalid Email: must be in the format ****@****.***";
        c="red";
        emailFlag=false;
    }
    else{
        m="Valid Email";
        c="green";
        emailFlag=true;
    }
    document.getElementById('emsg').style.color=c;
    document.getElementById('emsg').innerHTML=m;
}

function checkUsername(username){
    var unameExp=/^[a-zA-Z0-9_.-]{4,30}$/;
    if (username.length==0){
    m="";
    usernameFlag=false;
    }
    else if (!unameExp.test(username)){
        m="Invalid Username: must contain a minimum of 4 and a maximum of 30 letters, with no special characters";
        c="red";
        usernameFlag=false;
    }
    else{
        m="Valid Username";
        c="green";
        usernameFlag=true;
    }
    document.getElementById('umsg').style.color=c;
    document.getElementById('umsg').innerHTML=m;
}

function checkPassword(password){
    var passwordExp=/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/;
    if (password.length==0){
    m="";
    passwordFlag=false;
    }
    else if (!passwordExp.test(password)){
        m="Invalid Password: must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters";
        c="red";
        passwordFlag=false;
    }
    else{
        m="Valid Password";
        c="green";
        passwordFlag=true;
    }
    document.getElementById('pmsg').style.color=c;
    document.getElementById('pmsg').innerHTML=m;
}

function checkUserInputs(){
    document.forms[0].JSEnabled.value="TRUE";
    return (nameFlag && emailFlag && usernameFlag && passwordFlag);
}
