<?php // Pulls in the database connection string from our hidden .env file and seperates it into the different variables of the connection string

$ini = @parse_ini_file(".env");

if($ini && isset($ini["DB_URL"])){
    //load local .env file
    $url = $ini["DB_URL"];
    $db_url = parse_url($url);
}
else{
    //load from env variables
    $url = getenv("DB_URL");
    $db_url = parse_url($url);
    
}
//attempts to handle a failure where parse_url doesn't parse properly (usually happens when special characters are included)
if (!$db_url || count($db_url) === 0) {
    $matches;
    //below is a RexEx pattern. It's not really it's own language, but it's a way to match patterns in strings. You can read more about it here: https://learn.microsoft.com/en-us/dotnet/standard/base-types/regular-expression-language-quick-reference
    $pattern = "/mysql:\/\/(\w+):(\w+)@([^:]+):(\d+)\/(\w+)/i";
    preg_match($pattern, $url, $matches);
    $db_url["host"] = $matches[3];
    $db_url["user"] = $matches[1];
    $db_url["pass"] = $matches[2];
    $db_url["path"] = "/" . $matches[5];
}
$dbhost = $db_url["host"];
$dbuser = $db_url["user"];
$dbpass = $db_url["pass"];
$dbdatabase = substr($db_url["path"],1);
?>
