<?php

/*
 * Class: csci303fa21
 * User: ipjun
 * Date: 11/21/2021
 * Time: 2:38 AM
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

$password = "";

if($_SERVER['REQUEST_METHOD']  == "GET") {
    if ($_SESSION['ID'] == $_GET['q'] || $_SESSION['status'] == 1) {

        $sql = "SELECT ID, name, email FROM members WHERE ID = ?";
        $user = checkdup($pdo, $sql, $_GET['q']);
        $name = $user['name'];
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

    if($errexists == 0){

        $hashedpwd = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE members SET password = :password WHERE ID = :ID";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':password', $hashedpwd);
        $stmt->bindValue('ID', $id);
        $stmt->execute();

        echo "<p class='success success-large centered'>Password successfully updated!</p>";

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

    <form name="login" id="login" method="post" action="<?php echo $currentfile; ?>">
        <fieldset>
            <legend>Change Password for <?php echo $name;?></legend>


            <div class="input">
                <label for="password">Password: </label>
                <input type="password" name="password" id="password" minlength="8" maxlength="72" <?php if(isset($password)){echo "value='".htmlspecialchars($password, ENT_QUOTES, "UTF-8")."'> (At least 8 characters)";} else {echo ">  (At least 8 characters) $errpassword";} ?>
            </div>

            <div class="input">
                <input type="submit" name="submit" id="submit" value="Update">
            </div>
        </fieldset>
    </form>
    <?php
}
require_once "footer.php";
?>
