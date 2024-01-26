<?php
require_once(__DIR__ . "/../../partials/nav.php");
reset_session();
?>
<div class="container-fluid">
    <h1>Register</h1>
    <form onsubmit="return validate(this)" method="POST">
        <div class="mb-3">
            <label class="form-label" for="username">Create a Username</label>
            <input class="form-control" type="username" id="username" name="username" required />
        </div>
        <div class="mb-3">
            <label class="form-label" for="first_name">First Name</label>
            <input class="form-control" type="text" name="first_name" required maxlength="30" />
        </div>
        <div class="mb-3">
            <label class="form-label" for="last_name">Last Name</label>
            <input class="form-control" type="text" name="last_name" required maxlength="30" />
        </div>
        <div class="mb-3">
            <label class="form-label" for="grade">Select Your Grade</label>
            <select class="form-control" name="grade" id="grade" onchange="CheckGrade()">
                <option selected disabled>Select</option>
                <option value="Freshman">Freshman</option>
                <option value="Sophomore">Sophomore</option>
                <option value="Junior">Junior</option>
                <option value="Senior">Senior</option>
                <option value="Coach">Coach</option>
            </select>    
        </div>
        <div class="mb-3" id="student_id" hidden> <!-- Hide this input unless grade is a student -->
            <label class="form-label" for="student_id">Enter your Student ID number</label>
            <input class="form-control" type="number" name="student_id" id="student_id" />
        </div>
        <div class="mb-3">
            <label class="form-label" for="pw">Password</label>
            <input class="form-control" type="password" id="pw" name="password" required minlength="8" />
        </div>
        <div class="mb-3">
            <label class="form-label" for="confirm">Confirm your Password</label>
            <input class="form-control" type="password" name="confirm" required minlength="8" />
        </div>
        <input type="submit" class="mt-3 btn btn-primary" value="Register" />
        <p class="mt-3">Already have an account? <a href="login.php">Login</a></p>
    </form>
</div>
<script>
    function CheckGrade() { // Show student_id input if grade is a student
        let grade = document.getElementById("grade").value;
        let student_id = document.getElementById("student_id");
        if (grade == "Freshman" || grade == "Sophomore" || grade == "Junior" || grade == "Senior") {
            student_id.hidden = false;
            student_id.required = true;
        } else {
            student_id.hidden = true;
            student_id.required = false;
        }
    }

    function validate(form) {
        // JavaScript validation
        let username = form.username.value;
        let password = form.password.value;
        let confirm = form.confirm.value;
        let first_name = form.first_name.value;
        let last_name = form.last_name.value;
        let grade = form.grade.value;
        if (student_id.required == true) {
            let student_id = form.student_id.value;
        }

        if (!validateUsername(username)) {
            flash("A username must be between 3 and 16 characters, and can only contain lowercase letters, numbers, hyphens, and underscores. Please check and try again.", "error");
            return false;
        }
       if(!validatePassword(password)){
            flash("Password must be at least 8 characters, contain at least one number, one uppercase letter, one lowercase letter and one special character", "error");
            return false;
        }
        if(password != confirm){
            flash("Passwords do not match", "error");
            return false;
        }
        if (student_id.required == true){
            if(!validateStudentID(student_id)){
                flash("Invalid student ID", "error");
                return false;
            }
        }
        if(!validateName(first_name, last_name)){
            flash("Sorry, that name is not valid. Please check and try again.", "error");
            return false;
        }
        return true;
    }
</script>
<?php

 if(isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["confirm"]) && isset($_POST["first_name"]) && isset($_POST["last_name"]) && isset($_POST["grade"])){
     $username = $_POST["username"];
     $password = $_POST["password"];
     $confirm = $_POST["confirm"];
     $first_name = $_POST["first_name"];
     $last_name = $_POST["last_name"];
     $grade = $_POST["grade"];
    if(isset($_POST["student_id"])){
        $student_id = $_POST["student_id"];
    }else{
        $student_id = null;
    }
     error_log("Attemoting to register user: " . $username);
 }
// PHP Validation
     $hasError = false;
     //Detect if form not complelte
    if(isset($username) || isset($password) || isset($confirm) || isset($first_name) || isset($last_name) || isset($grade)){
        if(empty($username)){
            flash("Username is required");
            $hasError = true;
        }
        if(empty($first_name)){
            flash("First name is required");
            $hasError = true;}
        if(empty($last_name)){
            flash("Last name is required");
            $hasError = true;
        }
        if(empty($grade)){
            flash("Grade is required");
            $hasError = true;
        }
        if($grade == "Freshman" || $grade == "Sophomore" || $grade == "Junior" || $grade == "Senior"){
            if(empty($student_id)){
                flash("Student ID is required");
                $hasError = true;
            }
        }
        if(empty($password)){
            flash("Password is required");
            $hasError = true;
        }
        if(empty($confirm)){
            flash("Password Confirmation is required");
            $hasError = true;
        }
    // Detect is password rules are followed
    if(is_valid_password($password) == false){
        flash("Password must be at least 8 characters, contain at least one number, and one special character");
        $hasError = true;
 }
    //Check if passwords match
    if(isset($password) && $password != $confirm && strlen($password) > 0){
        flash("Passwords do not match");
        $hasError = true;
    }

    //Complete if registration is okay
    if(!$hasError and (isset($username) && isset($password) && isset($confirm) && isset($first_name))){
       // Hash password
       $hash = password_hash($password, PASSWORD_BCRYPT);
       $db = getDB();
       // Use prepare and placeholders to prevent SQL injection
         $stmt = $db->prepare("INSERT INTO Users (username, password, first_name, last_name, grade, student_id) VALUES (:username, :password, :first_name, :last_name, :grade, :student_id)");
        try{
            $r = $stmt->execute([
                ":username" => $username,
                ":password" => $hash,
                ":first_name" => $first_name,
                ":last_name" => $last_name,
                ":grade" => $grade,
                ":student_id" => $student_id
            ]);
            flash("Registration Successful. Welcome $first_name!");
        }catch(Exception $e){
            users_check_duplicate($e->errorInfo);
            error_log("Error inserting user: " . $e->getMessage());
        }
    }
}
?><?php require_once(__DIR__ . "/../../partials/flash.php"); ?>