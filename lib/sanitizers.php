<?php


function validate_email($email){
    if(preg_match('/(^[a-zA-Z0-9_.]+[@]{1}[a-z0-9]+[\.][a-z]+$)/m', $email)){ //Replaces FILTER_VALIDATE_EMAIL
        $boom = explode("@", $email);
        $domain = array_pop($boom);
        if ($domain == "taudelt.net" || $domain == "test.net") {
            return true;
        } else {
            flash("Please use your organization provided email.", "danger");
            return false;
        }
    
    }else{
        flash("The email entered is not valid. Please try again.", "danger");
        return false;
    }
}
function is_valid_username($username)
{
    return preg_match('/^[a-z0-9_-]{3,16}$/', $username);
}
function is_valid_password($password)
{
    return preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*]).{8,}$/', $password);
}