<?php

/*
 * Class: csci303fa21
 * User: ihphillip
 * Date: 11/18/2021
 * Time: 11:12 AM
 */

$pagename = "Search";
require_once "header.php";
$term = "";

if (isset($_GET['submit'])){
	if(empty($_GET['term'])){
		echo "<p class='error'>Search term is empty.</p>";
	}
	else{
		$term = trim($_GET['term']);



		$sql = "SELECT name, email FROM members WHERE name LIKE :term OR email LIKE :term";
		$stmt = $pdo->prepare($sql);
		$stmt->bindValue('term', $term."%");
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		if(empty($result)){
			echo "<p class='error'>No Results Found for ".htmlspecialchars($term, ENT_QUOTES, "UTF-8")."</p>";
		}

	}//search term present
}//form submitted
?>
	<p>Please enter the beginning of the member's name or email:</p>
	<form name="empsearch" id="empsearch" method="get" action="<?php echo $currentfile;?>">
		<label for="term">Search Term:</label>
		<input type="text" id="term" name="term" placeholder="Enter First Name" <?php if(isset($term)){echo "value='".htmlspecialchars($term, ENT_QUOTES, "UTF-8")."'";}?>>
		<input type="submit" id="submit" name="submit" value="submit">
	</form>

<?php


if(!empty($result)){
	echo "<table >
<tr>
	<th class='searchtable'>Name</th>
	<th class='searchtable'>Email</th>
</tr>";
	foreach ($result as $row) {
		echo "<tr><td class='searchtable'>{$row['name']}</td><td class='searchtable'>{$row['email']}</td>";
	}
	echo "</table>";
}

require_once "footer.php";
?>