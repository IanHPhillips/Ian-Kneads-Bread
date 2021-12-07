<?php

/*
 * Class: csci303fa21
 * User: ihphillip
 * Date: 9/7/2021
 * Time: 11:00 AM
 *
 * Font provided from Google Fonts https://fonts.google.com/specimen/Montserrat#standard-styles
 */

//Error Reporting
error_reporting(E_ALL);
ini_set('display_errors','1');

if(session_status()!=PHP_SESSION_ACTIVE){session_start();}
//Current file
$currentfile = basename($_SERVER['SCRIPT_FILENAME']);
require_once 'connection.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
		<script src="https://cdn.tiny.cloud/1/5o7mj88vhvtv3r2c5v5qo4htc088gcb5l913qx5wlrtjn81y/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
		<script>tinymce.init({ selector:'textarea' });</script>
        <title>Ian Kneads Bread - <?php echo $pagename;?></title>
		<link rel="stylesheet" href="styles.css">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">

    </head>
    <body>
        <header>
			<nav>
				<ul class="navigation"><?php
					echo ($currentfile == "index.php") ? "<li class='navcurrent'>Home</li>":"<li class='navlink'><a href='index.php'>Home</a></li>";
					echo ($currentfile == "signup.php") ? "<li class='navcurrent'>Signup</li>":"<li class='navlink'><a href='signup.php'>Signup</a></li>";
					echo ($currentfile == "search.php") ? "<li class='navcurrent'>Member Search</li>":"<li class='navlink'><a href='search.php'>Member Search</a></li>";
					if(isset($_SESSION['ID'])){echo ($currentfile == "list.php") ? "<li class='navcurrent'>Member List</li>":"<li class='navlink'><a href='list.php'>Member List</a></li>";}
					if(isset($_SESSION['ID'])  && $_SESSION['status'] == 1){echo ($currentfile == "additem.php") ? "<li class='navcurrent'>Add Item</li>":"<li class='navlink'><a href='additem.php'>Add Item</a></li>";}
					echo (isset($_SESSION['ID']))?  "<li class='navlink account'><a href='logout.php'>Logout</a></li>":"<li class='navlink account'><a href='login.php'>Login</a></li>";?>
				</ul>
			</nav>
            <h1  class="heading">Ian Kneads Bread</h1>
        </header>
        <main>
            <h2 class="heading"><?php echo $pagename; ?></h2>