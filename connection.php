<?php

/*
 * Class: csci303fa21
 * User: ihphillip
 * Date: 10/7/2021
 * Time: 11:03 AM
 */

$dsn= "mysql:host=localhost;dbname=303f1ihphillip";
$user = "303f1ihphillip";
$pass = "cscif10586";
$pdo = new PDO($dsn,$user,$pass);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>