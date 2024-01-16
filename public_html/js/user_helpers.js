function validateUsername(username) {
    const valid_username_regex = "^[a-z0-9_-]{3,16}$";
    if (username.match(valid_username_regex)) {
        return true;
    } else {
        return false;
    }
}
function validatePassword(password) {
    const valid_password_regex = "^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*]).{8,}$";
    if (password.match(valid_password_regex)) {
        return true;
    } else {
        return false;
    }
}
function generateUsername(email) {
    let username = email.split("@")[0];
    return username;
}
function validateName(first_name) {
    const valid_name_regex = "^[a-zA-Z ]{2,20}$";
    if (first_name.match(valid_name_regex)) {
        return true;
    } else {
        return false;
    }
}

