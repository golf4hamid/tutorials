<?php
require_once('DB_login.php');

try {
    $conn = new PDO("mysql:host=$db_host;dbname=$db_db;", $db_user, $db_pass, array(PDO::ATTR_PERSISTENT => true));
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $q = $_REQUEST['cat'];
    $stmt = $conn->prepare('SELECT cat_id FROM Categories WHERE name = :name');
    $stmt->bindParam(':name', $q);
    $stmt->execute();
    while($ids = $stmt->fetch(PDO::FETCH_NUM)){$id = $ids[0];}
    $stm = $conn->prepare('SELECT name FROM Types WHERE c_id = :id');
    $stm->bindParam(':id', $id);
    $stm->execute();
    while($que = $stm->fetch(PDO::FETCH_NUM)){
        echo "<li onclick='selected_type(\"$que[0]\")'><a href='javascript:void(0);'>".$que[0]."</a></li>";
    }
}catch (PDOException $err) {
    echo $err->getMessage();
}
