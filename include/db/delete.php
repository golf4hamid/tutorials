<?php
require_once('DB_login.php');
try {
    $conn = new PDO("mysql:host=$db_host;dbname=$db_db", $db_user, $db_pass);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if(isset($_REQUEST['delete']) && !isset($_REQUEST['query'])){
      # $_REQUEST Will Hold The Id Of The Selected Tutorial.
      $t_id = $_REQUEST['delete'];
      $t = $conn->prepare("SELECT name FROM course WHERE id = :id");
      $t->bindParam(':id', $t_id);
      $t->execute();
      while($rows = $t->fetch(PDO::FETCH_ASSOC)){
        $t_name= $rows['name'];
      }
      $tut = $conn->prepare("DELETE FROM course WHERE id = :id");
      $down = $conn->prepare("DELETE FROM downloads WHERE t_id = :id");
      $visit = $conn->prepare("DELETE FROM visits WHERE t_id = :id");
      $tut->bindParam(':id', $t_id);
      $down->bindParam(':id', $t_id);
      $visit->bindParam(':id', $t_id);
      $tut->execute();
      $down->execute();
      $visit->execute();
      echo "Done!";

    } elseif(isset($_REQUEST['query'])){
      $t_id = $_REQUEST['delete'];
      $tut = $conn->prepare("DELETE FROM request WHERE id = :id");
      $tut->bindParam(':id', $t_id);
      $tut->execute();
      echo "Done!";
    }
}catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
