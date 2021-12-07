<?php

/*
 * Class: csci303fa21
 * User: ihphillip
 * Date: 12/4/2021
 * Time: 7:10 PM
 */
$itemid=0;
require_once "connection.php";
$pagename = "Item Details";
 if(isset($_GET['q'])){
     $itemid = $_GET['q'];

     $sql = "SELECT * FROM items WHERE ID = :ID";
     $stmt = $pdo->prepare($sql);
     $stmt->bindParam(":ID", $itemid);
     $stmt->execute();
     $result = $stmt->fetch(PDO::FETCH_ASSOC);

     $pagename = "{$result['name']} Details";

     $sql = "SELECT intro, url, image, text, members.name AS membername, contributions.created AS created  FROM contributions JOIN items ON contributions.item_ID = items.ID JOIN members ON contributions.member_ID = members.ID WHERE contributions.item_ID = :ID ORDER BY contributions.created DESC ";
     $stmt = $pdo->prepare($sql);
     $stmt->bindParam(":ID", $itemid);
     $stmt->execute();
     $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
 }
 else{
     header("Location: .");
 }

require_once "header.php";
 ?>

<div id="item-details">
    <?php
    if(empty($result)){
        echo "<p class='centered'>Well, looks like no one was contributed to this yet. Maybe you could ";
        if(!isset($_SESSION['ID'])){ echo "login and ";}
        echo "be the first to contribute!</p>";
    }
    else{
        foreach ($result as $row){
        ?>
        <div class="item">
            <div class="item-title">
                <h3><?php echo $row['intro'];?></h3>
            </div>
            <div class="item-body">
                <div class="item-image">
                    <img src="<?php echo (empty($row['image'])) ? "images/bread.png":"/uploads/{$row['image']}"; ?> " alt="image of bread" >
                </div>
                <div class="item-text">
                <?php echo $row['text'];?>
                <a href="<?php echo $row['url'];?>">User provided link</a>
                <div class="author">By: <strong><?php
                        $time = strtotime($row['created']);
                        $time = date("g:i A \o\\n n/j/Y", $time);
                        echo $row['membername']."</strong> at $time";?></div>
                </div>

            </div>
        </div>
        <?php
        }
    }
    ?>
</div>
<?php
require_once "footer.php";
?>
