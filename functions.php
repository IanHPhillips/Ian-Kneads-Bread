<?php

/*
 * Class: csci303fa21
 * User: ipjun
 * Date: 10/19/2021
 * Time: 10:18 PM
 */

function checkdup($pdo, $sql, $field) {
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(1, $field);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row;
}

?>