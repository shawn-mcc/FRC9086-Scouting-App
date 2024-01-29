<?php

// Since we'll call nav at the beginning of every page, we can put all of our session logic and import statements here
// this way we don't have to repeat it on every page and it makes our code neater

require_once(__DIR__ . "/../lib/functions.php");
//Note: this is to resolve cookie issues with port numbers
$domain = $_SERVER["HTTP_HOST"];
if (strpos($domain, ":")) {
    $domain = explode(":", $domain)[0];
}
$localWorks = true; //some people have issues with localhost for the cookie params
//if you're one of those people make this false

//this is an extra condition added to "resolve" the localhost issue for the session cookie
if (($localWorks && $domain == "localhost") || $domain != "localhost") {
    session_set_cookie_params([
        "lifetime" => 60 * 60,
        "path" => "$BASE_PATH",
        //"domain" => $_SERVER["HTTP_HOST"] || "localhost",
        "domain" => $domain,
        "secure" => true,
        "httponly" => true,
        "samesite" => "lax"
    ]);
}
session_start();


?>
<!-- include css and js files used by bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- include our own css file -->
<link rel="stylesheet" href="<?php echo get_url('/style/main_style.css'); ?>">
<!-- include our js helper files -->
<script src="<?php echo get_url('/js/user_helpers.js'); ?>"></script>
<script src="<?php echo get_url('/js/flash_helper.js'); ?>"></script>
<script src="<?php echo get_url('/js/validations.js'); ?>"></script>

<!-- our Navbar -->
<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img src="<?php echo get_url('/img/9086_Logo.png'); ?>" width="100px" height = "100px" >       
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navContent" aria-controls="navContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ">
                <?php if (is_logged_in()) : ?>
                    <li class="nav-item"><a class="nav-link" href="<?php echo get_url('dashboard.php'); ?>">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo get_url('my_profile.php'); ?>">Profile</a></li>
                <?php endif; ?>
                <?php if (!is_logged_in()) : ?>
                    <li class="nav-item"><a class="nav-link" href="<?php echo get_url('index.php'); ?>">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo get_url('login.php'); ?>">Donate</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo get_url('login.php'); ?>">Calander</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo get_url('login.php'); ?>">Gallery</a></li>
                    <li class="nav-item" ><a class="nav-link" href="<?php echo get_url('login.php'); ?>">Login</a></li>
                    <li class="nav-item" ><a class="nav-link" href="<?php echo get_url('register.php'); ?>">Register</a></li>
                <?php endif; ?>
                <?php if (has_role("Admin")) : ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="rolesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Admin Tools
                        </a>
                        <ul class="dropdown-menu bg-warning" aria-labelledby="rolesDropdown">
                            <li><a class="dropdown-item" href="<?php echo get_url('admin/create_role.php'); ?>">Create New Roles</a></li>
                            <li><a class="dropdown-item" href="<?php echo get_url('admin/assign_roles.php'); ?>">Assign Users to Roles</a></li>
                            <li><a class="dropdown-item" href="<?php echo get_url('admin/manage_roles.php'); ?>">Manage Roles</a></li>
                        </ul>
                    </li>
                    <?php endif; ?>
                <?php if (is_logged_in()) : ?>
                    <li class="nav-item"><a class="nav-link" href="<?php echo get_url('logout.php'); ?>">Logout</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>