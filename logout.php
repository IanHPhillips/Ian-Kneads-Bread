<?php

/*
 * Class: csci303fa21
 * User: ipjun
 * Date: 11/17/2021
 * Time: 6:44 PM
 */
$pagename = "Logout";
 session_start();
 session_unset();
 session_destroy();
 header("Location: confirm.php?state=1");