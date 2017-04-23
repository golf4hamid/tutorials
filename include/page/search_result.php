<?php
require_once("../db/DB_login.php");
require_once("../class/tutorial.php");
	/* Here Goes The Search Result Area */

if(isset($_REQUEST['query'])){
	$query = $_REQUEST['query'];
	$c = 0;
	$conn = new PDO("mysql:host=$db_host;dbname=$db_db;", $db_user, $db_pass, array(PDO::ATTR_PERSISTENT => true));
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	# GET 'name' From Course
	$stmt = $conn->prepare("SELECT name FROM course WHERE name LIKE '%$query%'");
	//$stmt->bindParam(':n', $query);
	$stmt->execute();
	$container = "<div class='page-header'>
									<h4 class='text-center text-primary'>Results For : <i>$query</i></h4>
									<span calss='notification'>
										<a href='javascript:void(0);' onmouseenter='loadModal(\"include/page/ask_for_tut.php\" , \" $query \")' data-toggle='modal' data-target='#myModal'>Help?</a>
									</span>
							</div>";
	while($rows = $stmt->fetch(PDO::FETCH_ASSOC)){
		$tut = new Tutorial($rows['name']);
		$container .= $tut->box();
	}
	echo $container;
}
