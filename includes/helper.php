<?php

//function to trim values
function cleanData($value){
    return trim($value);
}


//function to sanitize value for string
function sanitizeStr($raw_value){
    return filter_var($raw_value, FILTER_SANITIZE_STRING);
}


//function to validate value for email
function validateEmail($rawEmail){
    return filter_var($rawEmail, FILTER_VALIDATE_EMAIL);
}


//function to validate value for integer
function validateInt($rawInt){
    return filter_var($rawInt, FILTER_VALIDATE_INT);
}


//function to redirect
function redirectPage($page){
    header("location: {$page}");
}

//function to keep error and success messages in a session 
function keepMsg($msg){
    if(empty($msg)){
        $msg ="";
    }else{
        $_SESSION['msg']    =   $msg;
    }
}


//function to display the stored message in the session super global
function showMsg(){
    if(isset($_SESSION['msg'])){
        echo $_SESSION['msg'];
        unset($_SESSION['msg']);
    }
}


//Create function to hash password using md5
function hashPassword($pass){
    return md5($pass);
}


?>



