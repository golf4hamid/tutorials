<?php
require_once("../db/DB_login.php");
require_once("../class/tutorial.php");
require_once "../db/users.php";
?>
<!DOCTYPE html>
<html>
<head>
	<title>Bootstrap Tutorial</title>
	<meta charset="utf-8">
	<meta http-equiv="refresh" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="../../css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../../css/jquery-ui.css">
	<link rel="stylesheet" type="text/css" href="../../css/index.css">
</head>
<body>
	<div class="container-fluid">
	  <div class="sub-container col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-0 col-lg-2">
	    <ul class="links nav">
	      <li>
					<a href="javascript:void(0);" onmouseenter="loadPage('add_tut.php');" data-toggle='modal' data-target='#myModal'>Add Tutorial</a>
				</li>
	      <li>
					<a href="javascript:void(0);" onclick="loadPage('all_tuts.php');">All Tutorials</a>
				</li>
	      <li>
					<a href="javascript:void(0);" onclick="loadPage();">Statistics</a>
				</li>
	      <li>
					<a href="javascript:void(0);" onclick="loadPage('../admin/requests.php');">Requests</a>
				</li>
				<li>
					<a href="javascript:void(0);" onclick="loadPage('../admin/Messages.php');">Messages</a>
				</li>
				<li>
					<a href="javascript:void(0);" onclick="loadPage();">Active Contries</a>
				</li>
	    </ul>
	  </div>
		<div class="container container-content col-xs-10 col-sm-10 col-xs-offset-1 col-md-6  col-lg-8">
				<h2>Content Area</h2>
		</div>
	</div>



  <script type="text/javascript" src='../../js/jquery-3.2.0.min.js'></script>
  <script type="text/javascript" src='../../js/bootstrap.js'></script>
  <script type="text/javascript" src='../../js/jquery-ui.js'></script>
  <script type="text/javascript" src="../../js/dom_get.js"></script>
  <script type="text/javascript" src="../../js/goto.js"></script>
  <script type="text/javascript" src="../../js/index.js"></script>
  <script type="text/javascript">
		loadPage('all_tuts.php');
	</script>
</body>
</html>
