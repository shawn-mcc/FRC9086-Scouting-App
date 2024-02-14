<?php
require(__DIR__ . "/../../partials/nav.php");
?>
<div class="container-fluid">
    <h1>Login</h1>
    <form onsubmit="return validate(this)" method="POST">
        <div class="mb-3">
            <label class="form-label" for="username">Username</label>
            <input class="form-control" type="text" id="username" name="username" required />
        </div>
        <div class="mb-3">
            <label class="form-label" for="pw">Password</label>
            <input class="form-control" type="password" id="pw" name="password" />
        </div>
        <input type="submit" class="mt-3 btn btn-primary" value="Login" />
        <p class="mt-3">Don't have an account? <a href="register.php">Register</a></p>
    </form>
</div>
<script>
    function validate(form) {
        // JavaScript validation
        let username = form.username.value;
        let password = form.password.value;
        if(validateUsername(email) == true){
            return true;
        }else{
            flash("Sorry, that username is not valid. Please check and try again.");
            return false;
        }
        if(password.length == 0){
            flash("Password is required");
            return false;
        }//Don't check if password follows password rules here. No need to have those rules visible outside of registration
        return true;  
    }
</script>
<?php

if (isset($_POST["username"]) && isset($_POST["password"])) {
    $username = se($_POST, "username", "", false);
    $password = se($_POST, "password", "", false);

    //PHP validation
    $hasError = false;
    //Detect if form not complete
    if (empty($username)) {
        flash("username must not be empty");
        $hasError = true;
    }
    if (empty($password)) {
        flash ("Password must not be empty");
        $hasError = true;
    }
    if (!is_valid_username($username)) {
        flash("Invalid username");
        $hasError = true;
    }
    // Check if password is empty. No need to show password rules on login page.
    if (empty($password)) {
        flash("password must not be empty");
        $hasError = true;
    }
    if (!$hasError) {
        // Login
        $db = getDB();
        $stmt = $db->prepare("SELECT id, username, password from Users where username = :username");
        try {
            $r = $stmt->execute([":username" => $username]);
            if ($r) {
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($user) {
                    $hash = $user["password"];
                    // Want the password to be availible for as little time as possible
                    unset($user["password"]);
                    if (password_verify($password, $hash)) {
                        //Start session for logged in user
                        $_SESSION["user"] = $user;
                        try {
                            //lookup potential roles
                            $stmt = $db->prepare("SELECT Roles.name FROM Roles 
                        JOIN UserRoles on Roles.id = UserRoles.role_id 
                        where UserRoles.user_id = :user_id and Roles.is_active = 1 and UserRoles.is_active = 1");
                            $stmt->execute([":user_id" => $user["id"]]);
                            $roles = $stmt->fetchAll(PDO::FETCH_ASSOC); //fetch all since we'll want multiple
                        } catch (Exception $e) {
                            error_log(var_export($e, true));
                        }
                        //save roles or empty array
                        if (isset($roles)) {
                            $_SESSION["user"]["roles"] = $roles; //at least 1 role
                        } else {
                            $_SESSION["user"]["roles"] = []; //no roles
                        }
                        flash("Welcome back " . get_username());
                        //Redirect to home page
                        die(header("Location: dashboard.php"));
                    } else {
                        flash("Invalid password");
                    }
                } else {
                    flash("Email not found");
                }
            }
        } catch (Exception $e) {
            flash("An error occurred while attempting to login, please try again later.");
            error_log("<pre>" . var_export($e, true) . "</pre>");
        }
    }
}
?>
<?php require_once(__DIR__ . "/../../partials/flash.php"); ?>