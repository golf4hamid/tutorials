<?php
  require_once('../db/DB_login.php');
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
      } elseif(isset($_REQUEST['query'])){
        $t_id = $_REQUEST['delete'];
        $t = $conn->prepare("SELECT type FROM request WHERE id = :id");
        $t->bindParam(':id', $t_id);
        $t->execute();
        while($rows = $t->fetch(PDO::FETCH_ASSOC)){
          $t_name= $rows['type'];
        }
      }
    }catch(PDOException $e){
      echo "Error : ". $e->getMessage();
    }
?>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Delete Tutorial</h4>
      </div>
      <div class="modal-body">
        <span class="alert alert-danger" role="alert">Do You Want To Delete: </span>
        <span class="alert alert-warning" role="alert"><?= $t_name?></span>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <?php
          if(isset($_REQUEST['query'])){
            echo "<button type=\"button\" onclick='deleteTut(\" $t_id \", \"". $_REQUEST['query']."\")' class=\"btn btn-danger\">Delete</button>";
          } else {
            echo "<button type=\"button\" onclick='deleteTut(\"$t_id\")' class=\"btn btn-danger\">Delete</button>";
          }
          ?>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
?>
