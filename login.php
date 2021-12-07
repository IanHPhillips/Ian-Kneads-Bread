<?php

/*
 * Class: csci303fa21
 * User: ipjun
 * Date: 11/17/2021
 * Time: 6:44 PM
 */
$pagename = "Login";
require_once "header.php";
require_once "functions.php";

$errexists = 0;
$erremail = "";

if($_SERVER['REQUEST_METHOD'] == "POST"){

    if(empty($_POST['email'])){
        $errexists = 1;
        $erremail = "<span class='error'>Email is required.</span>";
    }
    else {
        $email = strtolower(trim($_POST['email']));
    }
    //password
    if(empty($_POST['password'])){
        $errexists = 1;
        $errpassword = "<span class='error'>Password is required.</span>";
    }
    else{
        $password = $_POST['password'];
    }

    if($errexists == 0){
        $sql = "SELECT * FROM members WHERE email = ?";
        $userexists = checkdup($pdo, $sql, $email);
        if(empty($userexists) || password_verify($password, $userexists['password'])){
            $erremail = "<span class='error'>Email or password is incorrect.</span>";
        }
        else{

            $_SESSION['ID'] = $userexists['ID'];
            $_SESSION['name'] = $userexists['name'];
            $_SESSION['status'] = $userexists['status'];
            header("Location: confirm.php?state=2");
        }
    }
}

 ?>

<form name="login" id="login" method="post" action="<?php echo $currentfile; ?>">
    <fieldset>
        <legend>Login</legend>
        <div class="input">
            <label  for="email">Email: </label>
            <input type="email" name="email" id="email" maxlength="255" <?php if(isset($email)){echo "value='".htmlspecialchars($email, ENT_QUOTES, "UTF-8")."'";} if(isset($erremail)) {echo ">$erremail";} else{echo ">";} ?>
        </div>

        <div class="input">
            <label for="password">Password: </label>
            <input type="password" name="password" id="password" minlength="8" maxlength="72" <?php if(isset($password)){echo "value='".htmlspecialchars($password, ENT_QUOTES, "UTF-8")."'";}?> >
        </div>
        <div class="input">
            <input type="submit" name="submit" id="submit" value="Login">
        </div>
    </fieldset>
</form>
<?php
require_once "footer.php";
?>
