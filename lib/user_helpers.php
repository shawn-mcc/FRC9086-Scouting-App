<?php

/**
 * Passing $redirect as true will auto redirect a logged out user to the $destination.
 * The destination defaults to login.php
 */
function is_logged_in($redirect = false, $destination = "login.php")
{
    $isLoggedIn = isset($_SESSION["user"]);
    if ($redirect && !$isLoggedIn) {
        //if this triggers, the calling script won't receive a reply since die()/exit() terminates it
        flash("You must be logged in to view this page", "warning");
        die(header("Location: $destination"));
    }
    return $isLoggedIn;
}
function has_role($role)
{
    if (is_logged_in() && isset($_SESSION["user"]["roles"])) {
        foreach ($_SESSION["user"]["roles"] as $r) {
            if ($r["name"] === $role) {
                return true;
            }
        }
    }
    return false;
}
function get_username()
{
    if (is_logged_in()) { //we need to check for login first because "user" key may not exist
        return se($_SESSION["user"], "username", "", false);
    }
    return "";
}

function get_user_id()
{
    if (is_logged_in()) { //we need to check for login first because "user" key may not exist
        return se($_SESSION["user"], "id", false, false);
    }
    return false;
}

function find_user_by_id($user_id)
{
    $user_id = (int)($user_id);
    $db = getDB();
    $stmt = $db->prepare("SELECT * FROM Users WHERE id = :user_id");
    try {
        $stmt->execute([":user_id" => $user_id]);
        $results = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($results) {
            return $results;
        }
    } catch (PDOException $e) {
        error_log(var_export($e->errorInfo, true), "danger");
        flash("An unexpected error occurred, please try again later. If the issue persists, please contact the administrator", "danger");
    }
}
function fetch_all_users(){
    $db = getDB();
    $stmt = $db->prepare("SELECT * FROM Users");
    try {
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($results) {
            return $results;
        }
    } catch (PDOException $e) {
        error_log(var_export($e->errorInfo, true), "danger");
        flash("An unexpected error occurred, please try again later. If the issue persists, please contact the administrator", "danger");
    }
}

function users_check_duplicate($errorInfo)
{
    if ($errorInfo[1] === 1062) {
        //https://www.php.net/manual/en/function.preg-match.php
        preg_match("/Users.(\w+)/", $errorInfo[2], $matches);
        if (isset($matches[1])) {
            flash("The chosen " . $matches[1] . " is not available.", "warning");
        } else {
            flash("An error occurred", "danger");
            error_log("<pre>" . var_export($errorInfo, true) . "</pre>");
        }
    } else {
        flash("Error: Duplicate user", "danger");
        error_log("<pre>" . var_export($errorInfo, true) . "</pre>");
    }
}
