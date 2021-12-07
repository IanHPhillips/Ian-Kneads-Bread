<?php

/*
 * Class: csci303fa21
 * User: ihphillip
 * Date: 12/4/2021
 * Time: 7:10 PM
 */


$pagename = "Add Contribution";
require_once "header.php";


 if(!isset($_SESSION['ID'])){
     header("Location: .");
 }
$itemid = 0;
$url = "";

$errid = "";
$errintro = "";
$errurl = "";
$errimage = "";
$errtext = "";
$errexists = 0;
$showform = 1;

if($_SERVER['REQUEST_METHOD'] == "GET"){
    if(isset($_GET['q'])){
        $itemid = $_GET['q'];
    }
}

if($_SERVER['REQUEST_METHOD'] == "POST"){
   //id validation
    if(empty($_POST['ID'])){
        $errid = "<span class='error'>Item is Required.</span>";
        $errexists = 1;
    }
    else{
        $itemid = $_POST['ID'];
    }
    //intro validation
    if(empty($_POST['intro'])){
        $errintro = "<span class='error'>Intro is Required.</span>";
        $errexists = 1;

    }
    else{
        $intro = $_POST['intro'];
    }

    //url validation
    if(!empty($_POST['url'])){
        $url = $_POST['url'];
        if(!filter_var($url, FILTER_VALIDATE_URL)){
            $errurl = "<span class='error'>Not a valid url.</span>";
            $errexists = 1;
        }
    }
    else{
        $url = "";
    }

    //text validation
    if(empty($_POST['text'])){
        $errtext = "<span class='error'>Required.</span>";
        $errexists = 1;

    }
    else{
        $text = $_POST['text'];
    }

    //image validation
    if($_FILES['image']['error'] == 0){
        $pathparts = pathinfo($_FILES['image']['name']);
        $extension = strtolower($pathparts['extension']);
        $now = time();
        $finalfile = str_replace(' ', '_', $_SESSION['name']).$now.".".$extension;
        $workingfile = "/var/www/html/uploads/".$finalfile;
        if(file_exists($workingfile)){
            $errexists = 1;
            $errimage .= "<span class='error'>File already exist.</span>";
        }
        if($extension != "gif" && $extension != "jpg" && $extension != "jpeg" && $extension != "png"){
            $errexists = 1;
            $errimage .= "<span class='error'>File is not an image.</span>";
        }else{
            $imageinfo = getimagesize($_FILES['image']['tmp_name']);
            if($imageinfo[0] > 500 || $imageinfo[1] > 500){
                $errexists = 1;
                $errimage .= "<span class='error'>Image is too large (Max 500 x 500 px).</span>";
            }
        }
        if(!move_uploaded_file($_FILES['image']['tmp_name'], $workingfile)){
            $errexists = 1;
            $errimage .= "<span class='error'>Failed to save image.</span>";
        }
        else{
            $image = $finalfile;
        }
    }
    else{
        $errexists = 1;
        $errimage .= "<span class='error'>Problem with the image</span>";
    }

    if($errexists == 0){
        $sql = "INSERT INTO `contributions`(`item_ID`, `member_id`, `intro`, `url`, `image`, `text`, `created`) VALUES (:item_ID, :member_ID, :intro, :url, :image, :text, :created)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":item_ID", $itemid);
        $stmt->bindParam(":member_ID", $_SESSION['ID']);
        $stmt->bindParam(":intro", $intro);
        $stmt->bindParam(":url", $url);
        $stmt->bindParam(":text", $text);
        $stmt->bindParam(":image", $image);
        $stmt->bindValue(':created',date("Y-m-d H:i:s"));
        $stmt->execute();
        $showform = 0;
        echo "<p class='success centered'>Contribution Added.</p>";
    }else{
        echo "<p class='error'>Oops! There are errors. Please make changes and resubmit.</p>";
        $showform = 1;
    }
}
if($showform == 1)
{
 ?>

<form name="addcontr" id="addcontr" enctype="multipart/form-data" method="post" action="<?php echo $currentfile;?>">

    <div class="input">
        <label for="ID">Item: </label>
        <select name="ID" id="ID">
            <option value="">PICK ONE</option>
            <?php
            $sql = "SELECT * FROM items ORDER BY name DESC";

            $result = $pdo->query($sql);
            foreach ($result as $row){
                echo "<option value='{$row['ID']}'"; if(isset($itemid) && $itemid == $row['ID']){echo " selected";} echo ">{$row['name']}</option>";
            }
            ?>

        </select><?php if(!isset($itemid)){echo $errid;}?>
    </div>

    <div class="input">
        <label for="intro">Title: </label>
        <input type="text" name="intro" id="intro"<?php if(isset($intro)){echo "value='".htmlspecialchars($intro, ENT_QUOTES, "UTF-8")."'>";} else{echo "> $errintro";} ?>
    </div>

    <div class="input">
        <label for="text" class="input">What are your thoughts? <?php if(empty($text)){echo $errtext;}?></label>
        <textarea name="text" id="text"><?php if(isset($text)){echo htmlspecialchars($text, ENT_QUOTES, "UTF-8");}?></textarea>
    </div>
    <div class="input">
        <label for="url">(optional) Url : </label>
        <input type="url" name="url" id="url"<?php if(isset($url)){echo "value='".htmlspecialchars($url, ENT_QUOTES, "UTF-8")."'>";} else{echo "> $errurl";} ?>
    </div>

    <div class="input">
        <label for="image">(optional) Add an Image : </label><?php echo $errimage;?>
        <input type="file" name="image" id="image" >
    </div>

    <div class="input">
        <input class="button" type="submit" name="submit" id="submit" value="Submit">
    </div>
</form>

<?php
}
require_once "footer.php";
?>