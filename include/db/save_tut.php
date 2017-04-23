<?php
require_once('DB_login.php');
if(isset($_REQUEST['title']) && isset($_REQUEST['link1']) && isset($_REQUEST['desc']) && isset($_REQUEST['type'])) {

    $title = $_REQUEST['title'];
    $link = $_REQUEST['link1'];
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
        $stmt = $conn->prepare("INSERT INTO course(name, t_id, descr, link, image) VALUES(:m, :t_id, :descr, :link, :img)");
        $stmt->bindParam(':m', $title);
        $stmt->bindParam(':t_id', $t_id);
        $stmt->bindParam(':link', $link);
        $stmt->bindParam(':descr', $desc);
        $stmt->bindParam(':img', $img);
        $stmt->execute();
        $tut_id = $conn->lastInsertId();
        if($_REQUEST['req_id']){
          $req_id = $_REQUEST['req_id'];
          $stmt = $conn->prepare("UPDATE request SET status = 'Responsed', t_id =  :tut_id WHERE id = :id");
          $stmt->bindParam(':tut_id', $tut_id);
          $stmt->bindParam(':id', $req_id);
          $stmt->execute();

        }
        echo "Done Successfully";
    } catch (PDOException $err) {
        echo $err->getMessage();
    }
} else {
    echo "ERROR";
}
