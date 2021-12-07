<?php

/*
 * Class: csci303fa21
 * User: ipjun
 * Date: 11/10/2021
 * Time: 11:44 PM
 */


/*
* EXAMPLE FILE USED TO SEND EMAIL VIA PHPMAILER
* COPY THIS PAGE OF CODE AFTER YOUR INITIAL PHP COMMENTS
* FALL 2021
*/

//Include Required Files - Need Autoloader
//***** SPECIAL NOTE - THIS PATH WILL VARY DEPENDING ON LOCATION OF FILE *****
require_once 'PHPMailer/PHPMailerAutoload.php';
function sendemail($name, $email, $subject, $message){
    //Create a new PHPMailer instance
    $mail = new PHPMailer();

    //Set the hostname of the mail server
    $mail->Host = 'smtp.gmail.com';

    //Whether to use SMTP authentication
    $mail->SMTPAuth = true;

    //Username to use for SMTP authentication - use full email address for gmail
    //***** SPECIAL NOTE - DO NOT CHANGE FOR THIS CLASS *****
    $mail->Username = 'ccucsciweb@gmail.com';

    //Password to use for SMTP authentication
    //***** SPECIAL NOTE - DO NOT CHANGE FOR THIS CLASS *****
    $mail->Password = 'csci303&409';

    //Set the encryption
    $mail->SMTPSecure = 'ssl';

    //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
    $mail->Port = 465;

    //Set the subject line
    //***** SPECIAL NOTE - OFTEN USES A VARIABLE INSTEAD WHEN FULLY IMPLEMENTING AND INCLUDING THIS PAGE *****
    $mail->Subject = $subject;

    //Using HTML Email Body
    $mail->isHTML(true);

    //Set the Message Body
    //***** SPECIAL NOTE - OFTEN USES A VARIABLE INSTEAD WHEN FULLY IMPLEMENTING AND INCLUDING THIS PAGE *****
    $mail->Body = "<p >$message</p>";

    //Set who the message is to be sent from
    $mail->setFrom('ccucsciweb@gmail.com', 'CSCI 303 Email');

    //Set who the message is to be sent to
    /*
     * CHANGE THE CODE BELOW TO YOUR EMAIL IN YOUR INITIAL TESTING!!!
     * SPECIAL NOTE - OFTEN USES VARIABLES INSTEAD WHEN FULLY IMPLEMENTING AND INCLUDING THIS PAGE *****
     */
    $mail->addAddress($email, $name);

    //send the message, check for errors
    if ($mail->send()) {
        return 1;
    } else {
        return 0;
    }
}