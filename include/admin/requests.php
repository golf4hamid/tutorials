<?php
try {
  require_once("../db/DB_login.php");
  require_once("../class/tutorial.php");
  require_once "../db/users.php";
    $conn = new PDO("mysql:host=$db_host;dbname=$db_db", $db_user, $db_pass);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT * FROM request");
    $stmt->execute();

    echo "<div class=\"container-fluid\">";
    echo "<table class='table table-bordered table-responsive'>";
            echo "<thead>";
                echo "<tr>";
                    echo "<td><span>Request ID</span></td>";
                    echo "<td><span>Request Type</span></td>";
                    echo "<td><span>Request Details</span></td>";
                    echo "<td><span>Request Date</span></td>";
                    echo "<td><span>Request Status</span></td>";
                echo "</tr>";
            echo "</thead>";
            echo "<tbody>";

                while($rows = $stmt->fetch(PDO::FETCH_ASSOC)){
                  $status = $rows['status'];

                  switch ($status) {
                    case 'Not Yeat':
                      $st = false;
                      break;
                    case 'Responsed':
                      $st = true;
                      break;

                    default:
                      case 'Not Yeat':
                      break;
                  }
                    echo "<tr>";
                        echo "<td><button data-toggle='modal' data-target='#myModal' type='button' onmouseenter='loadDelete(\"". $rows['id'] ."\", \"request\");' class='btn btn-danger'>". $rows['id'] ."<span class='glyphicon glyphicon-trash'></span></span></td>";
                        if($st){
                          $tuto = new Tutorial($rows['type']);
                          echo "<td><a href='javascript:void(0);' onmouseenter='getModal(\"". $tuto->tutorial_id ."\");' data-toggle='modal' data-target='#myModal'>". $tuto->title ."</a></td>";
                        } else {
                          echo "<td><a href='javascript:void(0);' onmouseenter='response(\"".$rows['type']."\", \"".$rows['id']."\")' data-toggle='modal' data-target='#myModal'>". $rows['type'] ."</a></td>";
                        }

                        echo "<td><span>". $rows['details'] ."</span></td>";
                        echo "<td><span>". $rows['r_date'] ."</span></td>";
                        echo "<td><span> $status </span></td>";
                    echo "</tr>";
                }



            echo "</tbody>";
        echo "</table>";
        echo "</div>";

}
catch(PDOException $e)
{
    echo "Connection failed: " . $e->getMessage();
}
?>
