<?php
require(__DIR__ . "/../../partials/nav.php");
?>
<?php
if (is_logged_in(true)) {
    $user = find_user_by_id(get_user_id());
    $user_id = $user["id"];
    $user_name = $user["first_name"];
}else{
    flash("You must be logged in to access this page");
    die(header("Location: login.php"));
}
?>
<div class="container-fluid">
    <h1 id="Dashboard Title"><?php echo $user_name ?>'s Dashboard</h1>