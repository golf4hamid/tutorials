<?php
require_once("include/db/DB_login.php");
require_once("include/class/tutorial.php");
require_once "include/db/users.php";
require_once "include/page/slider.php";
if(isset($_COOKIE['user'])){
	$user = $_COOKIE['user'];
} else {
	$conn = new PDO("mysql:host=$db_host;dbname=$db_db;", $db_user, $db_pass, array(PDO::ATTR_PERSISTENT => true));
	$stmt = $conn->prepare("SELECT id FROM active ORDER BY id DESC LIMIT 1");
	$stmt->execute();
	while($rows = $stmt->fetch(PDO::FETCH_ASSOC)){
		$user = "user". $rows['id'];
	}
	$ip = getenv('HTTP_CLIENT_IP')?:
			getenv('HTTP_X_FORWARDED_FOR')?:
					getenv('HTTP_X_FORWARDED')?:
							getenv('HTTP_FORWARDED_FOR')?:
									getenv('HTTP_FORWARDED')?:
											getenv('REMOTE_ADDR');

	$stmt = $conn->prepare("SELECT * FROM active WHERE ip = :ip");
	$stmt->bindParam(':ip', $ip);
	$stmt->execute();
	while ($rows = $stmt->fetch(PDO::FETCH_ASSOC)) {
		if(isset($rows['ip'])){
			$user = $rows['name'];
			setcookie("user", $user, time() + (60*60*365), "/", "localhost", FALSE, FALSE);
			$set = true;
		}
	}
	if(!$set){
		$stmt = $conn->prepare("INSERT INTO active(name, ip) VALUES(:n, :ip)");
		$stmt->bindParam(':n', $user);
		$stmt->bindParam(':ip', $ip);
		$stmt->execute();
		setcookie("user", $user, time() + (60*60*365), "/", "localhost", FALSE, FALSE);
	}

}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Bootstrap Tutorial</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/jquery-ui.css">
	<link rel="stylesheet" type="text/css" href="css/index.css">


</head>
<?php
	/* Here Goes The Main Content Of The Main Page */
	include "include/page/header.php";
?>

<div class="container">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#new" data-toggle="tab">New</a></li>
            <li><a href="#top" data-toggle="tab">Top</a></li>
            <li><a href="#views" data-toggle="tab">Most Viewed</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade in active" id="new">
							<?php
								echo $d_n;
							 ?>
            </div>
            <div class="tab-pane fade" id="top">
							<?php
								echo $d_t;
							 ?>
            </div>
						<div class="tab-pane fade" id="views">
							<?php
								echo $d_v;
							 ?>
            </div>
        </div>

</div>
<div class="container main-container">
	<?php
	require_once('include/page/main.php');
	?>
</div>
<?php

	require_once "include/page/footer.php";
?>

<script type="text/javascript" src='js/jquery-3.2.0.min.js'></script>
<script type="text/javascript" src='js/bootstrap.js'></script>
<script type="text/javascript" src='js/jquery-ui.js'></script>
<script type="text/javascript" src="js/dom_get.js"></script>
<script type="text/javascript" src="js/goto.js"></script>
<script type="text/javascript" src="js/index.js"></script>
<script type="text/javascript"></script>
