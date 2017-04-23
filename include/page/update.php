<?php

require_once('../db/DB_login.php');
try {
    $conn = new PDO("mysql:host=$db_host;dbname=$db_db", $db_user, $db_pass);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT * FROM course WHERE id = :id");
    $stmt->bindParam(':id', $_REQUEST['modal']);
    $stmt->execute();
    while ($rows = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $t = $rows['name'];
      $desc = $rows['descr'];
      $l = $rows['link'];
      $l2 = $rows['link2'];
      $stm = $conn->prepare("SELECT name, c_id FROM types WHERE id = :id");
      $stm->bindParam(':id', $rows['t_id']);
      $stm->execute();
      while ($r = $stm->fetch(PDO::FETCH_ASSOC)) {
        $ty = $r['name'];
        $c_id = $r['c_id'];
        $s = $conn->prepare("SELECT name FROM categories WHERE cat_id = :id");
        $s->bindParam(':id', $r['c_id']);
        $s->execute();
        while ($ro = $s->fetch(PDO::FETCH_ASSOC)) {
          $cat = $ro['name'];
        }
      }
    }
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
        <h4 class="modal-title text-primary text-center" id="myModalLabel">Update Tutorial</h4>
      </div>
      <form class="form form-group modal-body" method="post" onsubmit="saveTut('u'); return false;">
          <div class="row">
            <div class="input-group col-xs-10 col-xs-offset-1">
                <span class="input-group-addon">Toturilal's Title</span>
                <?="<input class='form-control' required type='text' id='title' name='title' value='$t' placeholder='EX: Learn Essential Training'/>";?>
            </div>
            <div class="input-group col-xs-10 col-xs-offset-1">
                <span class="input-group-addon">Toturilal's Link</span>
                <input class="form-control" required type="text" id="link1" <?="value=\"$l\""?> name="url1" placeholder="EX: http://www.example.com/">
            </div>
          </div>
          <div class="row">
            <div class="input-group col-xs-10 col-xs-offset-1">
                <span class="input-group-addon">Toturial Description</span>
                <textarea class="form-control" required id="desc" name="description">
                    <?= $desc;?>
                </textarea>
            </div>
              <div class="input-group col-xs-10 col-xs-offset-1">
                  <span class="input-group-addon">Toturilal's Image</span>
                  <input class="form-control" type="text" id="img" name="img"  placeholder="EX: http://www.example.com/images/001.jpg/">
              </div>
          </div>
          <div class="row control_type col-xs-10 col-xs-offset-1">
              <div class="cat_select col-xs-4">
                  <button id="category-btn" type="button" class="dropdown-toggle btn btn-default" data-toggle="dropdown" aria-expanded="false" aria-haspopup="true">
                      <?= $cat; ?>
                      <span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu" id="cat_list">
                      <?php
                      echo "<script>adminType(\"$cat\");</script>";
                      $stmt = $conn->prepare("SELECT name FROM categories");
                      $stmt->execute();
                      while($rows = $stmt->fetch(PDO::FETCH_NUM)){
                          echo "<li onclick='adminType(\"$rows[0]\")'><a href='javascript:void(0);'>".$rows[0]."</a></li>";
                      }
                      ?>
                  </ul>
              </div>
              <div class="cat_select col-xs-4 col-xs-offset-2">
                  <button id="type-btn" type="button" class="dropdown-toggle btn btn-default" data-toggle="dropdown" aria-expanded="false" aria-haspopup="true">
                      <?= $ty; ?>
                      <span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu" id="type_list">
                      <?php
                      $stmt = $conn->prepare("SELECT name FROM types WHERE c_id = :id");
                      $stmt->bindParam('id', $c_id);
                      $stmt->execute();
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
