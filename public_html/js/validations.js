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
function validateName(first_name, last_name) {
    const valid_name_regex = "^[a-zA-Z ]{2,20}$";
    if (first_name.match(valid_name_regex) && last_name.match(valid_name_regex)) {
        return true;
    } else {
        return false;
    }
}
function validateStudentID(student_id) {
    const valid_student_id_regex = "^[0-9]{5}$";
    if (student_id.match(valid_student_id_regex)) {
        return true;
    } else {
        return false;
    }
}

