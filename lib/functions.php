<?php //this is a file that simply calls all the other files in the lib folder so we don't have to call them all individually in each page we create

require_once(__DIR__ . "/db.php"); //We have to call db first since the files below it require it.

$BASE_PATH = '/team_members'; //we also set our base path here so we can use it in other files.
//since the public facing site doesn't interact with the back end at all, this makes it easier to get to the backend for our app when we do need it

require(__DIR__ . "/flash_messages.php");
require(__DIR__ . "/safer_echo.php");
require(__DIR__ . "/user_helpers.php");
require(__DIR__ . "/reset_session.php");
require(__DIR__ . "/get_url.php");
require(__DIR__ . "/sanitizers.php");
?>