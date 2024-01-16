<?php
require_once(__DIR__ . "/../../partials/nav.php");
reset_session();
?>
<div class="container-fluid">
    <h1>Register</h1>
    <form onsubmit="return validate(this)" method="POST">
        <div class="mb-3">
            <label class="form-label" for="username">Username</label>
            <input class="form-control" type="username" id="username" name="username" required />
        </div>
        <div class="mb-3">
            <label class="form-label" for="first_name">First Name</label>
            <input class="form-control" type="text" name="first_name" required maxlength="30" />
            <br />
        <div class="mb-3">
            <label class="form-label" for="grade">Select Your Grade</label>
            <select class="form-control" name="grade">
                <option value="Freshman">Freshman</option>
                <option value="Sophomore">Sophomore</option>
                <option value="Junior">Junior</option>
                <option value="Senior">Senior</option>
                <option value="Coach">Coach</option>
            </select>    
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
    function validate(form) {
        // JavaScript validation
        let username = form.username.value;
        let password = form.password.value;
        let confirm = form.confirm.value;
        let first_name = form.first_name.value;
        let grade = form.grade.value;

        if (!validateUsername(username)) {
            flash("Sorry, that name is not valid. Please check and try again.");
            return false;
        }
       if(!validatePassword(password)){
            flash("Password must be at least 8 characters, contain at least one number, one uppercase letter, one lowercase letter and one special character");
            return false;
        }
        if(password != confirm){
            flash("Passwords do not match");
            return false;
        }
        if(!validateName(first_name)){
            flash("Sorry, that name is not valid. Please check and try again.");
            return false;
        }
        return true;
    }
</script>
<?php

 if(isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["confirm"]) && isset($_POST["first_name"])){
     $username = $_POST["username"];
     $password = $_POST["password"];
     $confirm = $_POST["confirm"];
     $first_name = $_POST["first_name"];
     $grade = $_POST["grade"];
     error_log("Registering user: " . $username);
 }
// PHP Validation
     $hasError = false;
     //Detect if form not complelte
    if(isset($username) || isset($password) || isset($confirm) || isset($first_name)){
        if(empty($username)){
            flash("Username is required");
            $hasError = true;
        }if(empty($first_name)){
            flash("First name is required");
            $hasError = true;}
        if(empty($password)){
            flash("Password is required");
            $hasError = true;
        }if(empty($confirm)){
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
         $stmt = $db->prepare("INSERT INTO Users (username, password, first_name, grade) VALUES (:username, :password, :first_name, :grade)");
        try{
            $r = $stmt->execute([
                ":username" => $username,
                ":password" => $hash,
                ":first_name" => $first_name,
                ":grade" => $grade
            ]);
            flash("Registration Successful. Welcome $first_name!");
        }catch(Exception $e){
            users_check_duplicate($e->errorInfo);
            error_log("Error inserting user: " . $e->getMessage());
        }
    }
}
?><?php require_once(__DIR__ . "/../../partials/flash.php"); ?>