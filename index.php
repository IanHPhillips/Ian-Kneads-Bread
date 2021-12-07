<?php

/*
 * Class: csci303fa21
 * User: ihphillip
 * Date: 8/26/2021
 * Time: 11:54 AM
 */

$pagename = "Welcome to Ian Kneads Bread";
require_once "header.php";

$sql = "SELECT * FROM `items` ORDER BY name DESC";
$stmt = $pdo->prepare($sql);

$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

	<p class="home-info">Come one, come all. Ian Kneads Bread holds some of your bread related topics. Check below for all the breads you can talk about. Come on in, grab a roll, and tell us what you think about different breads!</p>

    <table class="index-table centered">
        <tr>
            <th class="searchtable">Bread</th>
            <th class="searchtable">View Details</th>
            <?php
            if(isset($_SESSION['ID'])){
            ?>
            <th class="searchtable">Add Contribution</th>
            <?php
            }
            ?>
        </tr>
        <?php
            foreach ($result as $row){
                ?>
                <tr>
                    <td class="searchtable"><?php echo $row['name'];?></td><td class="searchtable"><a href="itemdetails.php?q=<?php echo $row['ID'];?>">Details</a></td><?php if(isset($_SESSION['ID'])){ ?><td class="searchtable"><a href="addcontribution.php?q=<?php echo $row['ID'];?>">Contribute</a></td><?php } ?>
                </tr>
                <?php
            }
        ?>

    </table>
<?php
require_once "footer.php";
?>