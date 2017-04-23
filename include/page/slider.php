<?php
// INIT Connection to Database
    $conn = new PDO("mysql:host=$db_host;dbname=$db_db;", $db_user, $db_pass, array(PDO::ATTR_PERSISTENT => true));
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
# If The Slide Set To "Top"
    {
        $d_t = "
            <div class='carousel slide' id='tutorials_t'>
              <ol class='carousel-indicators'>
                <li class='active' data-target='#tutorials_t' data-slide-to='0'></li>
                <li data-target='#tutorials_t' data-slide-to='1'></li>
                <li data-target='#tutorials_t' data-slide-to='2'></li>
                <li data-target='#tutorials_t' data-slide-to='3'></li>
                <li data-target='#tutorials_t' data-slide-to='4'></li>
                <li data-target='#tutorials_t' data-slide-to='5'></li>
                <li data-target='#tutorials_t' data-slide-to='6'></li>
                <li data-target='#tutorials_t' data-slide-to='7'></li>
                <li data-target='#tutorials_t' data-slide-to='8'></li>
                <li data-target='#tutorials_t' data-slide-to='9'></li>
              </ol>
              <div class='carousel-inner' id='tutorials_con'>
          ";
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
                        if ($x == 2) {
                            $d_t .= "<div class=\"item active\">";
                        } else {
                            $d_t .= "<div class=\"item\">";
                        }
                        $d_t .= "
                                    <img class=\"img-responsive\" src=\"image/placeholder/" . strtolower($t->type) . ".png\" />
                                    <div class=\"carousel-caption\">
                                        <h3 class='media-heading text-center'>
                                            <a class='' onclick='goto_page(\"include/class/tutorial.php?tutorial=$t->title\");  save_act(\"$t->tutorial_id\", \"view\")'>$t->title</a>
                                        </h3>
                                        <div class='tutorial_gender btn-group pull-right'>
                                            <button class='btn btn-default tutorial_cat'  onclick='refer(\"$t->category\", \"cat\")'>$t->category</button>
                                            <button class='btn btn-default tutorial_type' onclick='refer(\"$t->type\", \"type\")'>$t->type</button>
                                        </div>
                                        <p class='clearfix'></p>
                                        <p class=\"text-warning carousel-desc\">$t->desc</p>
                                    </div>
                                  </div>
                            ";

                    }
            }
            $d_t .= "</div> <a href=\"#tutorials_t\" class=\"carousel-control left\" data-slide=\"prev\"><span class=\"glyphicon glyphicon-chevron-left\"></span></a>
                <a href=\"#tutorials_t\" class=\"carousel-control right\" data-slide=\"next\"><span class=\"glyphicon glyphicon-chevron-right\"></span></a>";
            $d_t .= "</div>";
    } // END OF TOP
# If The Slide Set To "New"
{
    $d_n = "
      <div class='carousel slide' id='tutorials_n'>
        <ol class='carousel-indicators'>
          <li class='active' data-target='#tutorials_n' data-slide-to='0'></li>
          <li data-target='#tutorials_n' data-slide-to='1'></li>
          <li data-target='#tutorials_n' data-slide-to='2'></li>
          <li data-target='#tutorials_n' data-slide-to='3'></li>
          <li data-target='#tutorials_n' data-slide-to='4'></li>
          <li data-target='#tutorials_n' data-slide-to='5'></li>
          <li data-target='#tutorials_n' data-slide-to='6'></li>
          <li data-target='#tutorials_n' data-slide-to='7'></li>
          <li data-target='#tutorials_n' data-slide-to='8'></li>
          <li data-target='#tutorials_n' data-slide-to='9'></li>
        </ol>
        <div class='carousel-inner' id='tutorials_con'>
    ";
        $stmt = $conn->prepare('SELECT id FROM course ORDER BY id DESC LIMIT 10');
        $stmt->execute();
        $new = array();
        while ($rows = $stmt->fetch(PDO::FETCH_NUM)) {
            array_push($new, $rows[0]);
        }
        arsort($new);
        for ($n = 0; $n < count($new); $n++) {
                $stmt = $conn->prepare('SELECT name FROM course WHERE id = :id');
                $stmt->bindParam(':id', $new[$n]);
                $stmt->execute();
                while ($rows = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $t = new Tutorial($rows['name']);
                    if ($n == 0) {
                        $d_n .= "<div class=\"item active\">";
                    } else {
                        $d_n .= "<div class=\"item\">";
                    }
                    $d_n .= "
                                <img class=\"img-responsive\" src=\"image/placeholder/" . strtolower($t->type) . ".png\"/>
                                <div class=\"carousel-caption\">
                                    <h3 class='media-heading text-center'>
                                        <a class='' onclick='goto_page(\"include/class/tutorial.php?tutorial=$t->title\");  save_act(\"$t->tutorial_id\", \"view\")'>$t->title</a>
                                    </h3>
                                    <div class='tutorial_gender btn-group pull-right'>
                                        <button class='btn btn-default tutorial_cat'  onclick='refer(\"$t->category\", \"cat\")'>$t->category</button>
                                        <button class='btn btn-default tutorial_type' onclick='refer(\"$t->type\", \"type\")'>$t->type</button>
                                    </div>
                                    <p class='clearfix'></p>
                                    <p class=\"text-warning carousel-desc\">$t->desc</p>
                                </div>
                            </div>
                        ";
                }
        }
        $d_n .= "</div> <a href=\"#tutorials_n\" class=\"carousel-control left\" data-slide=\"prev\"><span class=\"glyphicon glyphicon-chevron-left\"></span></a>
            <a href=\"#tutorials_n\" class=\"carousel-control right\" data-slide=\"next\"><span class=\"glyphicon glyphicon-chevron-right\"></span></a>";
        $d_n .= "</div>";
} // END OF NEW





{
    $d_v = "
        <div class='carousel slide' id='tutorials_v'>
          <ol class='carousel-indicators'>
            <li class='active' data-target='#tutorials_v' data-slide-to='0'></li>
            <li data-target='#tutorials_v' data-slide-to='1'></li>
            <li data-target='#tutorials_v' data-slide-to='2'></li>
            <li data-target='#tutorials_v' data-slide-to='3'></li>
            <li data-target='#tutorials_v' data-slide-to='4'></li>
            <li data-target='#tutorials_v' data-slide-to='5'></li>
            <li data-target='#tutorials_v' data-slide-to='6'></li>
            <li data-target='#tutorials_v' data-slide-to='7'></li>
            <li data-target='#tutorials_v' data-slide-to='8'></li>
            <li data-target='#tutorials_v' data-slide-to='9'></li>
          </ol>
          <div class='carousel-inner' id='tutorials_con'>
      ";
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
        $x = 10;
        for($x = 10; $x >= 0; $x--){
          $stmt = $conn->prepare('SELECT name FROM course WHERE id = :id');
          $stmt->bindParam(':id', $arr[$x]);
          $stmt->execute();
          while ($rows = $stmt->fetch(PDO::FETCH_NUM)) {
                    $t = new Tutorial($rows[0]);
                    if ($x == 0) {
                        $d_v .= "<div class=\"item active\">";
                    } else {
                        $d_v .= "<div class=\"item\">";
                    }
                    $d_v .= "
                                <img class=\"img-responsive\" src=\"image/placeholder/" . strtolower($t->type) . ".png\" />
                                <div class=\"carousel-caption\">
                                    <h3 class='media-heading text-center'>
                                        <a class='' onclick='goto_page(\"include/class/tutorial.php?tutorial=$t->title\");  save_act(\"$t->tutorial_id\", \"view\")'>$t->title</a>
                                    </h3>
                                    <div class='tutorial_gender btn-group pull-right'>
                                        <button class='btn btn-default tutorial_cat'  onclick='refer(\"$t->category\", \"cat\")'>$t->category</button>
                                        <button class='btn btn-default tutorial_type' onclick='refer(\"$t->type\", \"type\")'>$t->type</button>
                                    </div>
                                    <p class='clearfix'></p>
                                    <p class=\"text-warning carousel-desc\">$t->desc</p>
                                </div>
                              </div>
                        ";

                }
        }
        $d_v .= "</div>
                  <a href=\"#tutorials_v\" class=\"carousel-control left\" data-slide=\"prev\">
                    <span class=\"glyphicon glyphicon-chevron-left\"></span>
                  </a>
                  <a href=\"#tutorials_v\" class=\"carousel-control right\" data-slide=\"next\">
                    <span class=\"glyphicon glyphicon-chevron-right\"></span>
                  </a>
                </div>";
} // END OF VIEW
