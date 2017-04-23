<?php

require_once('../db/DB_login.php');
try {
    $conn = new PDO("mysql:host=$db_host;dbname=$db_db", $db_user, $db_pass);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $q = "SELECT name FROM categories";
    $stmt = $conn->prepare($q);
    $stmt->execute();
}
catch(PDOException $e)
{
    echo "Connection failed: " . $e->getMessage();
}
?>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title text-primary text-center" id="myModalLabel">Add Tutorial</h4>
      </div>
        <form class="form-group row" method="post" onsubmit="saveTut('c'); return false;">
        <div class="row">
          <div class="input-group col-xs-10  col-xs-offset-1">
              <span class="input-group-addon">Toturilal's Title</span>
              <?php
                if (isset($_REQUEST['query'])) {
                  $tut = $_REQUEST['query'];
                  echo "<input class='form-control' required type='text' id='title' name='title' value='$tut' placeholder='EX: Learn Essential Training'/>";
                } else {
                  echo "<input class='form-control' required type='text' id='title' name='title' placeholder='EX: Learn Essential Training'/>";
                }
                echo "<span class='hidden' id=\"req_id\">". $_REQUEST['id'] ."</span>";
               ?>
          </div>
          <div class="input-group col-xs-10  col-xs-offset-1">
              <span class="input-group-addon">Toturilal's Link</span>
              <input class="form-control" required type="text" id="link1" name="url1" placeholder="EX: http://www.example.com/">
          </div>
        </div>
        <div class="row">
          <div class="input-group col-xs-10  col-xs-offset-1">
              <span class="input-group-addon">Toturial Description</span>
              <textarea class="form-control" required id="desc" value="Write a description to the Toturial..." name="description"></textarea>
          </div>
            <div class="input-group col-xs-10  col-xs-offset-1">
                <span class="input-group-addon">Toturilal's Image</span>
                <input class="form-control" type="text" id="img" name="img" placeholder="EX: http://www.example.com/images/001.jpg/">
            </div>
        </div>
        <div class="row control_type col-xs-10  col-xs-offset-1">
            <div class="cat_select col-xs-4 col-xs-offset-1">
                <button id="category-btn" type="button" class="dropdown-toggle btn btn-default" data-toggle="dropdown" aria-expanded="false" aria-haspopup="true">
                    Categorey
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" id="cat_list">
                    <?php
                    while($rows = $stmt->fetch(PDO::FETCH_NUM)){
                        echo "<li onclick='adminType(\"$rows[0]\")'><a href='javascript:void(0);'>".$rows[0]."</a></li>";
                    }
                    ?>
                </ul>
            </div>
            <div class="cat_select col-xs-4 col-xs-offset-1">
                <button id="type-btn" type="button" class="dropdown-toggle btn btn-default" data-toggle="dropdown" aria-expanded="false" aria-haspopup="true" disabled>
                    Type
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" id="type_list">
                    <?php
                    while($rows = $stmt->fetch(PDO::FETCH_NUM)){
                        echo "<li><a href='javascript:void(0);'>".$rows[0]."</a></li>";
                    }
                    ?>
                </ul>
            </div>
        </div>
        <div class="row">
          <input class="btn btn-md btn-success" type="submit" id="save_tot" value="Save Toturial"/>
        </div>
      </form>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
  </div>
