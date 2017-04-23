<?php
if(isset($_REQUEST['call'])){
    require_once("../db/DB_login.php");
    require_once("../class/tutorial.php");
}
$conn = new PDO("mysql:host=$db_host;dbname=$db_db;", $db_user, $db_pass, array(PDO::ATTR_PERSISTENT => true));
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    {
        $con_new = "<div class=\"jumbotron\">
                <h3 class='main-page-header'>Last Added Tutorials</h3>
                <div class=\"row tut_container\">";
        $stmt = $conn->prepare('SELECT name FROM course ORDER BY add_time DESC LIMIT 12');
        $stmt->execute();
        while ($rows = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $t = new Tutorial($rows['name']);
            $con_new .= $t->box();
        }
        $con_new .= "</div></div>";
    }




    {
        $con_top = "<div class=\"jumbotron\">
                <h3 class='main-page-header'>Top Downloaded Tutorials</h3>
                <div class=\"row tut_container\">";
        $stmt = $conn->prepare('SELECT t_id FROM downloads');
        $stmt->execute();
        $arr = array();
        while ($rows = $stmt->fetch(PDO::FETCH_NUM)) {
            array_push($arr, $rows[0]);
        }
        $state = array_count_values($arr);
        asort($state);
        $c = 0;
        $arr = array();
        foreach($state as $k => $v) {
          if ($c <= 10) {
              array_push($arr, $k);
            }
            $c++;
        }
        for($x = 10; $x >= 0; $x--){
          $stmt = $conn->prepare('SELECT name FROM course WHERE id = :id');
          $stmt->bindParam(':id', $arr[$x]);
          $stmt->execute();
          while ($rows = $stmt->fetch(PDO::FETCH_NUM)) {
              $t = new Tutorial($rows[0]);
              $con_top .= $t->box();
          }
        }
        $con_top .= "</div></div>";
    }



    {
        $con_view = "<div class=\"jumbotron\">
                <h3 class='main-page-header'>Top Visited Tutorials</h3>
                <div class=\"row tut_container\">";
        $stmt = $conn->prepare('SELECT t_id FROM visits');
        $stmt->execute();
        $arr = array();
        while ($rows = $stmt->fetch(PDO::FETCH_NUM)) {
            array_push($arr, $rows[0]);
        }
        $state = array_count_values($arr);
        asort($state);
        $c = 0;
        $arr = array();
        foreach($state as $k => $v) {
          if ($c <= 10) {
              array_push($arr, $k);
            }
            $c++;
        }
        for($x = 10; $x >= 0; $x--){
          $stmt = $conn->prepare('SELECT name FROM course WHERE id = :id');
          $stmt->bindParam(':id', $arr[$x]);
          $stmt->execute();
          while ($rows = $stmt->fetch(PDO::FETCH_NUM)) {
              $t = new Tutorial($rows[0]);
              $con_view .= $t->box();
          }
        }
        $con_view .= "</div></div>";
    }
    echo "<div class='container main-page'>";
    echo $con_top;
    echo $con_new;
    echo $con_view;
    echo  "</div>";
?>
