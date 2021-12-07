<?php

/*
 * Class: csci303fa21
 * User: ihphillip
 * Date: 12/4/2021
 * Time: 5:43 PM
 */

$pagename = "Add Item";
require_once "header.php";
//Initial Variables
$errexists=0;
$erritemname="";
$itemname = "";
$match=0;
if($_SERVER['REQUEST_METHOD'] == "POST"){

	$submit=trim($_POST['submit']);

	//name
	if(empty($_POST['itemname'])){
		$errexists = 1;
		$erritemname = "<span class='error'>Item name is required.</span>";
	}
	else{
		if($_POST['itemname'] < 30) {
			$itemname = trim($_POST['itemname']);
		}
		else{
			$errexists = 1;
			$erritemname = "<span class='error'>Item name is too long, max 30 characters.</span>";
		}
	}

	if($errexists == 0){

		$sql = "SELECT name FROM items";
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($result as $row){
			if(!strcasecmp($row['name'], $itemname)){
				$match = 1;
			}
		}
		if($match == 0){
			$sql = "INSERT INTO items(`name`) VALUES (:name) ";
			$stmt = $pdo->prepare($sql);
			$stmt->bindParam(":name", $itemname);
			$stmt->execute();
			echo "<p class='success centered'>Item added to the system.</p>";
		}else{
			echo "<p class='error centered'>Item already present in the system.</p>";
		}


	}else{
		echo "<p class='error centered'>Oops! There are errors. Please make changes and resubmit.</p>";
	}

}


?>


<form name="additem" id="additem" method="POST" action="<?php echo $currentfile;?>">

	<div class="input">
		<label for="itemname">Item Name</label>
		<input type="text" name="itemname" id="itemname" maxlength="30"<?php if(isset($itemname)){echo "value='".htmlspecialchars($itemname, ENT_QUOTES, "UTF-8")."'>";} else{echo "> $erritemname";} ?>
	</div>

	<div class="input">
		<input class="button" type="submit" name="submit" id="submit" value="Submit">
	</div>
</form>
<?php
require_once "footer.php";
?>