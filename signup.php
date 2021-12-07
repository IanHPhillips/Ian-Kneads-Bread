<?php

/*
 * Class: csci303fa21
 * User: ihphillip
 * Date: 11/4/2021
 * Time: 10:37 AM
 */
//Populate the page name variable for use in header code.
$pagename = "Signup";

//Include the header with require_once
require_once "header.php";
require_once "functions.php";
require_once "email.php";

//Initial Variables
$showform = 1; //flag to determine whether to show the initial form or not.
$errexists=0;
$errname="";
$errlname="";
$erremail="";
$errusername="";
$errpassword="";
$errgender="";
$errbio="";
$errfavstate="";


//Checks to see if the request method is post.  See https://www.php.net/manual/en/reserved.variables.server.php
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	$submit=trim($_POST['submit']);

	//name
	if(empty($_POST['name'])){
		$errexists = 1;
		$errname = "<span class='error'>Name is required.</span>";
	}
	else{
		$name=trim($_POST['name']);
	}


	//email
    if(empty($_POST['email'])){
        $errexists = 1;
        $erremail = "<span class='error'>Email is required.</span>";
    }
    else{
        $email=strtolower(trim($_POST['email']));
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            $sql = "SELECT * FROM members WHERE email = ?";
            $emailexists = checkdup($pdo, $sql, $email);
            if (!empty($emailexists)) {
                $errexists = 1; //update the general error flag
                $erremail .= "<span class='error'>This email is taken.</span>";
            }
        }
        else{
            $errexists = 1; //update the general error flag
            $erremail .= "<span class='error'>Email is not valid.</span>";
        }

    }

	//password
	if(empty($_POST['password'])){
		$errexists = 1;
		$errpassword = "<span class='error'>Password is required.</span>";
	}
	elseif (strlen($_POST['password']) < 8){
		$errexists = 1;
		$errpassword = "<span class='error'>Password is too short.</span>";
	}
    elseif (strlen($_POST['password']) > 72){
        $errexists = 1;
        $errpassword = "<span class='error'>Password is too long.</span>";
    }
	else{
		$password = $_POST['password'];
	}


	//After we process the form, we hide the form by changing the flag
	if($errexists == 0) {
		$hashedpwd = password_hash($password, PASSWORD_DEFAULT);
		$sql = "INSERT INTO `members`(`name`, `email`, `password`, `created`, `updated`) VALUES (:name, :email, :password, :created, :updated)";
		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(':name',$name);
		$stmt->bindValue(':email',$email);
		$stmt->bindValue(':password',$hashedpwd);
		$stmt->bindValue(':created',date("Y-m-d H:i:s"));
        $stmt->bindValue(':updated',date("Y-m-d H:i:s"));
		$stmt->execute();
		$showform = 0;

        $emailmessage = "Thank you for registering $name.";
        $emailsubject = "Registration Confirmation - Ian's Pit Stop";
        if(sendemail($name, $email,$emailsubject, $emailmessage)){
		    echo "<p class='success success-large centered'>Registration successful, nice to meet you $name.</p>";

        ?>
        <div style="text-align: center;">
            <a href="index.php" id="return-home">Return to Home</a>
        </div>
        <?php
        }
        else{
            $sql = "DELETE FROM `members` WHERE email = :email";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':email',$email);
            $stmt->execute();
        }
	}
	else{
		echo "<p class='error'>Oops! There are errors. Please make changes and resubmit.</p>";
		$showform = 1;
	}
}
/*   Using a block of code to put the entire form inside the if statement.
 *   The closing brace is AFTER the form in a block of PHP code
 */

if ($showform == 1)
{
	?>

	<form name="registraion" id="registraion" method="post" action="<?php echo $currentfile;?>">
		<fieldset>
			<legend>Registraion</legend>
			<div class="input">
				<label for="name">First Name: </label>
				<input type="text" name="name" id="name" maxlength="50" <?php if(isset($name)){echo "value='".htmlspecialchars($name, ENT_QUOTES, "UTF-8")."'>";} else{echo "> $errname";} ?>
			</div>

			<div class="input">
				<label  for="email">Email: </label>
				<input type="email" name="email" id="email" maxlength="255" <?php if(isset($email)){echo "value='".htmlspecialchars($email, ENT_QUOTES, "UTF-8")."'";} if(isset($erremail)) {echo ">$erremail";} else{echo ">";} ?>
			</div>

			<div class="input">
				<label for="password">Password: </label>
				<input type="password" name="password" id="password" minlength="8" maxlength="72" <?php if(isset($password)){echo "value='".htmlspecialchars($password, ENT_QUOTES, "UTF-8")."'> (At least 8 characters)";} else {echo ">  (At least 8 characters) $errpassword";} ?>
			</div>

			<div class="input">
				<input class="button" type="submit" name="submit" id="submit" value="submit">
			</div>
		</fieldset>
	</form>

	<?php
} //Closes the if statement for showform

//Include the footer with require_once
require_once "footer.php";
?>