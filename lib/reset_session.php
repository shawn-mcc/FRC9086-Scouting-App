<?php
//this function will reset the session and start a new one. This prevents bugs with users logging in and out.
function reset_session()
{
    //all 3 of these functions are built in to PHP to deal with sessions - so we don't have to worry too much about the details
    session_unset();
    session_destroy();
    session_start();
}