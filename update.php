<?php

/*
 * Class: csci303fa21
 * User: ihphillip
 * Date: 11/18/2021
 * Time: 12:00 PM
 */
$pagename = "Update User";
require_once "header.php";
require_once "functions.php";

$showform = 1;
$errexists = 0;
$erremail = "";
$errname = "";
$errpassword = "";
$id = "";
$name = "";
$email = "";
$password = "";

if($_SERVER['REQUEST_METHOD']  == "GET") {
    if ($_SESSION['ID'] == $_GET['q'] || $_SESSION['status'] == 1) {

        $sql = "SELECT ID, name, email FROM members WHERE ID = ?";
        $user = checkdup($pdo, $sql, $_GET['q']);
        $name = $user['name'];
        $email = $user['email'];
        $id = $user['ID'];

    }
    else{
        header("Location: .");
    }
}

if($_SERVER['REQUEST_METHOD'] == "POST"){

    if(!empty($_POST['ID'])){
        $id = $_POST['ID'];
    }

    if(empty($_POST['name'])){
        $errexists = 1;
        $errname = "<span class='error'>Name is required.</span>";
    }
    else{
        $name = trim($_POST['name']);
    }

    if(empty($_POST['email'])){
        $errexists = 1;
        $erremail = "<span class='error'>Email is required.</span>";
    }
    else{
        $email=strtolower(trim($_POST['email']));
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            $sql = "SELECT * FROM members WHERE email = ?";
            $emailexists = checkdup($pdo, $sql, $email);
            if (!empty($emailexists) && $emailexists['email'] != $email) {
                $errexists = 1; //update the general error flag
                $erremail .= "<span class='error'>This email is taken.</span>";
            }
        }
        else{
            $errexists = 1; //update the general error flag
            $erremail .= "<span class='error'>Email is not valid.</span>";
        }

    }

	if($errexists == 0){


        $sql = "UPDATE members SET name = :name, email = :email WHERE ID = :ID";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':name', $name);
        $stmt->bindValue(':email',$email);
        $stmt->bindValue('ID', $id);
        $stmt->execute();

        echo "<p class='success success-large centered'>Information successfully updated!</p>";

        ?>
        <div style="text-align: center;">
            <a href="index.php" id="return-home">Return to Home</a>
        </div>
        <?php
        $showform = 0;
	}
    else{
        echo "<p class='error'>Oops! There are errors. Please make changes and resubmit.</p>";
        $showform = 1;
    }
}
if($showform == 1){
?>

<form name="update" id="update" method="post" action="<?php echo $currentfile; ?>">
	<fieldset>
		<legend>Update Info</legend>

        <input type="hidden" name="ID" id="ID" value="<?php echo $id;?>">
        <div class="input">
            <label  for="name">Name: </label>
            <input type="text" name="name" id="name" maxlength="255" <?php if(isset($name)){echo "value='".htmlspecialchars($name, ENT_QUOTES, "UTF-8")."'";} if(isset($er)) {echo ">$erremail";} else{echo ">";} ?>
        </div>

		<div class="input">
			<label  for="email">Email: </label>
			<input type="email" name="email" id="email" maxlength="255" <?php if(isset($email)){echo "value='".htmlspecialchars($email, ENT_QUOTES, "UTF-8")."'";} if(isset($erremail)) {echo ">$erremail";} else{echo ">";} ?>
		</div>

		<div class="input">
			<input class="button" type="submit" name="submit" id="submit" value="Update">
		</div>
	</fieldset>
</form>
<?php
}
require_once "footer.php";
?>
