<?php
require_once("DB_login.php");
if(isset($_REQUEST['action'])  && isset($_REQUEST['id'])){
  $conn = new PDO("mysql:host=$db_host;dbname=$db_db;", $db_user, $db_pass, array(PDO::ATTR_PERSISTENT => true));
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $user = $_COOKIE['user'];

  $stmt = $conn->prepare("SELECT id FROM active WHERE name LIKE '%$user%' LIMIT 1");
  $stmt->execute();
  while($rows = $stmt->fetch(PDO::FETCH_ASSOC)){
    $u_id = $rows['id'];
  }
  $user_act = $_REQUEST['action'];

  $t_id = $_REQUEST['id'];
  if($user_act === "download"){
      $stmt = $conn->prepare("INSERT INTO downloads(t_id, au_id) VALUES(:t_id, :u_id)");
  } elseif ($user_act === "view") {
      $stmt = $conn->prepare("INSERT INTO visits(t_id, au_id) VALUES(:t_id, :u_id)");
  }
  $stmt->bindParam(':t_id', $t_id);
  $stmt->bindParam(':u_id', $u_id);
  $stmt->execute();
  echo " Action Saved";
}
