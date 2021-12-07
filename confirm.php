<?php

/*
 * Class: csci303fa21
 * User: ipjun
 * Date: 11/17/2021
 * Time: 6:51 PM
 */
$pagename = "Confirm";
session_start();
 require_once 'header.php';

if($_GET['state'] == 1){
    echo "<p class='success-large centered'>Successfully Logged Out.</p>";
}
elseif ($_GET['state'] == 2){
    echo "<p class='success-large centered'>Welcome Back {$_SESSION['name']}!</p>";
}

require_once 'footer.php';