<?php
  require_once("../db/DB_login.php");
  $conn = new PDO("mysql:host=$db_host;dbname=$db_db", $db_user, $db_pass);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if(isset($_REQUEST['cat'])){ #=> if The query is an exacte CATEGOREY View All Tutorials Of This Categorey

      $category = $_REQUEST['cat'];
      $cat = $conn->prepare("SELECT cat_id FROM categories WHERE name = :n"); # Get The ID Of The Category.
      $cat->bindParam(':n', $category);
      $cat->execute();
      while($r = $cat->fetch(PDO::FETCH_ASSOC)){ # cat_id Holds The ID of The Category.
        $cat_id = $r['cat_id'];
      }

      $cat = $conn->prepare("SELECT * FROM types WHERE c_id = :n"); # Get All Types inside a Category.
      $cat->bindParam(':n', $cat_id);
      $cat->execute();
      $types = array(); # $types Will Hold The Names of The Types.
      $types_id = array(); # $types Will Hold The IDs of The Types.
      while($r = $cat->fetch(PDO::FETCH_ASSOC)){
        array_push($types, $r['name']);
        array_push($types_id, $r['id']);
      }

      #=> Get All The Tutorials in The Category.
      for($i =0; $i < count($types); $i++){
        $tuts = $conn->prepare("SELECT * FROM course WHERE t_id = :n"); # Get All Types inside a Category.
        $tuts->bindParam(':n', $types_id[$i]);
        $tuts->execute();
        while($t = $tuts->fetch(PDO::FETCH_ASSOC)){
          $t_name = $t['name'];
          $t_id = $t['id'];
          $t_descr = $t['descr'];
          $t_type = $types[$i];
          $t_cat = $category;
          $t_img = $t['image'];
          $t_adate = $t['add_time'];
          echo "<tr>";
              echo "<td><button data-toggle='modal' data-target='#myModal' type='button' onmouseenter='loadDelete(\"". $t_id ."\");' class='btn btn-danger'>". $t_id ."<span class='glyphicon glyphicon-trash'></span></span></td>";
              echo "<td><a href='javascript:void(0);' onmouseenter='getModal(\"". $t_id ."\");' data-toggle='modal' data-target='#myModal'>". $t_name ."</a></td>";
              echo "<td><a href='javascript:void(0);' onclick='loadGender(\"type\", \"$t_type\")'>". $t_type ."</a></td>";
              echo "<td><a href='javascript:void(0);' onclick='loadGender(\"cat\", \"$t_cat\"'>". $t_cat ."</a></td>";
              $s = $conn->prepare("SELECT id FROM visits WHERE t_id = :id");
              $s->bindParam(':id', $t_id);
              $s->execute();
              $n = 0;
              while ($r = $s->fetch(PDO::FETCH_ASSOC)) {
                $n++;
              }
              echo "<td><span>". $n ."</span></td>";
              $s = $conn->prepare("SELECT id FROM downloads WHERE t_id = :id");
              $s->bindParam(':id', $t_id);
              $s->execute();
              $n = 0;
              while ($r = $s->fetch(PDO::FETCH_ASSOC)) {
                $n++;
              }
              echo "<td><span>". $n ."</span></td>";
              echo "<td><span>". $t_adate ." </span></td>";
              echo "</tr>";
        }
      }
      echo "</tbody>";

    } elseif(isset($_REQUEST['type'])){ #=> if The Query is An exacte Type View All Tutorials of This Type.

      $type = $_REQUEST['type'];
      $ty = $conn->prepare("SELECT * FROM types WHERE name = :n"); # Get Type's ID.
      $ty->bindParam(':n', $type);
      $ty->execute();
      while ($r = $ty->fetch(PDO::FETCH_ASSOC)) {
        $type_id = $r['id'];
        $cat_id = $r['c_id'];
      }
      $cat = $conn->prepare("SELECT name FROM categories WHERE cat_id = :id"); # Get The Name Of The Category.
      $cat->bindParam(':id', $cat_id);
      $cat->execute();
      while ($r = $cat->fetch(PDO::FETCH_ASSOC)) {
        $cat_name = $r['name'];
      }
      $tuts = $conn->prepare("SELECT * FROM course WHERE t_id = :id"); # Get All Types inside a Category.
      $tuts->bindParam(':id', $type_id);
      $tuts->execute();
      while($t = $tuts->fetch(PDO::FETCH_ASSOC)){
        $t_name = $t['name'];
        $t_id = $t['id'];
        $t_descr = $t['descr'];
        $t_type = $type;
        $t_cat = $cat_name;
        $t_img = $t['image'];
        $t_adate = $t['add_time'];
        echo "<tr>";
            echo "<td><button data-toggle='modal' data-target='#myModal' type='button' onmouseenter='loadDelete(\"". $t_id ."\");' class='btn btn-danger'>". $t_id ."<span class='glyphicon glyphicon-trash'></span></span></td>";
          echo "<td><a href='javascript:void(0);' onmouseenter='getModal(\"". $t_id ."\");' data-toggle='modal' data-target='#myModal'>". $t_name ."</a></td>";
          echo "<td><a href='javascript:void(0);' onclick='loadGender(\"type\", \"$t_type\"'>". $t_type ."</a></td>";
          echo "<td><a href='javascript:void(0);' onclick='loadGender(\"cat\", \"$t_cat\"'>". $t_cat ."</a></td>";
          $s = $conn->prepare("SELECT id FROM visits WHERE t_id = :id");
          $s->bindParam(':id', $t_id);
          $s->execute();
          $n = 0;
          while ($r = $s->fetch(PDO::FETCH_ASSOC)) {
            $n++;
          }
          echo "<td><span>". $n ."</span></td>";
          $s = $conn->prepare("SELECT id FROM downloads WHERE t_id = :id");
          $s->bindParam(':id', $t_id);
          $s->execute();
          $n = 0;
          while ($r = $s->fetch(PDO::FETCH_ASSOC)) {
            $n++;
          }
          echo "<td><span>". $n ."</span></td>";
          echo "<td><span>". $t_adate ." </span></td>";
          echo "</tr>";
      }
    }
