<?php
try {
  require_once("../db/DB_login.php");
  require_once("../class/tutorial.php");
  require_once "../db/users.php";
    $conn = new PDO("mysql:host=$db_host;dbname=$db_db", $db_user, $db_pass);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $cat = $conn->prepare("SELECT * FROM categories");
    $cat->execute();
      echo "<h3 class=\"admin-title text-primary text-center\">
              View All Available Tutorials.
            </h3>";
    echo "<div class=\"cat_select col-xs-4\">
        <button id=\"category-btn\" type=\"button\" class=\"dropdown-toggle btn btn-default\" data-toggle=\"dropdown\" aria-expanded=\"false\" aria-haspopup=\"true\">
            Categorey
            <span class=\"caret\"></span>
        </button>
        <ul class=\"dropdown-menu\" id=\"list\">";
    while ($cats = $cat->fetch(PDO::FETCH_ASSOC)) {

      echo "<li onclick='loadGender(\"cat\", \"".$cats['name']."\")'><a href='javascript:void(0);'>".$cats['name']."</a></li>";
    }
    echo "</ul></div>";
    $stmt = $conn->prepare("SELECT * FROM course");
    $stmt->execute();

    echo "<div class=\"container-fluid\">";
    echo "<table class='table table-bordered table-responsive'>";
            echo "<thead>";
                echo "<tr>";
                    echo "<td><span>ID</span></td>";
                    echo "<td><span>Name</span></td>";
                    echo "<td><span>Type</span></td>";
                    echo "<td><span>Category</span></td>";
                    echo "<td><span>Views</span></td>";
                    echo "<td><span>Downloads</span></td>";
                    echo "<td><span>Added Date</span></td>";
                echo "</tr>";
            echo "</thead>";
            echo "<tbody class='all-tuts'>";

                while($rows = $stmt->fetch(PDO::FETCH_ASSOC)){
                    echo "<tr>";
                        echo "<td><button data-toggle='modal' data-target='#myModal' type='button' onmouseenter='loadDelete(\"". $rows['id'] ."\");' class='btn btn-danger'>". $rows['id'] ."<span class='glyphicon glyphicon-trash'></span></span></td>";
                        echo "<td><a href='javascript:void(0);' onmouseenter='getModal(\"". $rows['id'] ."\");' data-toggle='modal' data-target='#myModal'>". $rows['name'] ."</a></td>";
                        $s = $conn->prepare("SELECT name, c_id FROM types WHERE id = :id");
                        $s->bindParam(':id', $rows['t_id']);
                        $s->execute();
                        while ($r = $s->fetch(PDO::FETCH_ASSOC)) {
                          $t_name = $r['name'];
                          $st = $conn->prepare("SELECT name FROM categories WHERE cat_id = :id");
                          $st->bindParam(':id', $r['c_id']);
                          $st->execute();
                          while ($ro = $st->fetch(PDO::FETCH_ASSOC)) {
                            $c_name = $ro['name'];
                          }
                        }
                        echo "<td><a href='javascript:void(0);' onclick='loadGender(\"type\", \"$t_name\")'>". $t_name ."</a></td>";
                        echo "<td><a href='javascript:void(0);' onclick='loadGender(\"cat\", \"$c_name\")'>". $c_name ."</a></td>";
                        $s = $conn->prepare("SELECT id FROM visits WHERE t_id = :id");
                        $s->bindParam(':id', $rows['id']);
                        $s->execute();
                        $n = 0;
                        while ($r = $s->fetch(PDO::FETCH_ASSOC)) {
                          $n++;
                        }
                        echo "<td><span>". $n ."</span></td>";
                        $s = $conn->prepare("SELECT id FROM downloads WHERE t_id = :id");
                        $s->bindParam(':id', $rows['id']);
                        $s->execute();
                        $n = 0;
                        while ($r = $s->fetch(PDO::FETCH_ASSOC)) {
                          $n++;
                        }
                        echo "<td><span>". $n ."</span></td>";
                        echo "<td><span>". $rows['add_time'] ." </span></td>";
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
