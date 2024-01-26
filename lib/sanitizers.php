<?php

// Valid Regex for username is lowercase letters, numbers, underscores, and hyphens 
// between 3 and 16 characters in length.
function is_valid_username($username)
{
    return preg_match('/^[a-z0-9_-]{3,16}$/', $username);
}

// Valid Regex for password is at least 8 characters long, 
// contains at least one number, one uppercase letter, one lowercase letter and one special character
function is_valid_password($password)
{
    return preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*]).{8,}$/', $password);   
}