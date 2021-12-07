<?php

/*
 * Class: csci303fa21
 * User: ihphillip
 * Date: 11/18/2021
 * Time: 11:38 AM
 */

$pagename = "List";
require_once "header.php";

$sql = "SELECT * FROM `members`";
$stmt = $pdo->prepare($sql);

$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

if(isset($_SESSION['ID'])){

	if(!empty($result)){
?>
<table >
	<tr>
		<th class='searchtable'>Name</th>
		<th class='searchtable'>Email</th>
	</tr>";
    <?php
		foreach ($result as $row) {

			 echo "<tr><td class='searchtable'>{$row['name']}</td><td class='searchtable'>{$row['email']}</td>";

            if($_SESSION['ID'] == $row['ID'] || $_SESSION['status'] == 1){

				echo "<td class='searchtable'><a href='update.php?q={$row['ID']}'>Update</a></td><td class='searchtable'><a href='changepass.php?q={$row['ID']}'>Change Password</a></td>";


            }
		}
        ?>
</table>
<?php
    }
}
else{
	header("Location: .");
}
require_once "footer.php";
?>