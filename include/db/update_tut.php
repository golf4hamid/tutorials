<?php
require_once('DB_login.php');
if(isset($_REQUEST['title']) && isset($_REQUEST['link1']) && isset($_REQUEST['desc']) && isset($_REQUEST['type'])) {
    $title = $_REQUEST['title'];
    $link = $_REQUEST['link1'];
    $tut_id = $_REQUEST['id'];
    $img = $_REQUEST['img'];
    $desc = $_REQUEST['desc'];
    $type = $_REQUEST['type'];
    $conn = new PDO("mysql:host=$db_host; dbname=$db_db", $db_user, $db_pass, array(PDO::ATTR_PERSISTENT => true));
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    try {
        $stmt = $conn->prepare("SELECT id FROM types WHERE name = :n");
        $stmt->bindParam(':n', $type);
        $stmt->execute();
        while($r = $stmt->fetch(PDO::FETCH_NUM)) {
            $t_id = $r[0];
        }
        $stmt = $conn->prepare("UPDATE course SET name = :m, t_id = :t_id, descr = :descr, link = :link, image = :img WHERE id = :id");
        $stmt->bindParam(':m', $title);
        $stmt->bindParam(':t_id', $t_id);
        $stmt->bindParam(':id', $tut_id);
        $stmt->bindParam(':link', $link);
        $stmt->bindParam(':descr', $desc);
        $stmt->bindParam(':img', $img);
        $stmt->execute();
        echo "Done Successfully";
    } catch (PDOException $err) {
        echo $err->getMessage();
    }
} else {
    echo "ERROR";
}
