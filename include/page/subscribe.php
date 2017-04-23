<?php 
	/* Here Goes The Area To Make The User Subscribe :*/
		#	Register Email Name Type of courses to Send [..., ...., ...., ....]
	require_once("include/db/DB_login.php");
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
	<form class="form-group row">
		<div class="row">
			<h4 class="page-header col-xs-12">Welcome to the subcription page</h4>
		</div>
		<div class="row">
			<div class="input-group col-xs-9 col-sm-9 col-md-4 col-lg-4 col-xs-offset-1 col-sm-offset-1 col-md-offset-1 col-lg-offset-1">
				<span class="input-group-addon">Full Name</span>
				<input class="form-control" required type="text" name="f_name" placeholder="EX: Jhone Doe"/>
			</div>
			<div class="input-group col-xs-9 col-sm-9 col-md-4 col-lg-4 col-xs-offset-1 col-sm-offset-1 col-md-offset-1 col-lg-offset-1">
				<span class="input-group-addon">E-mail</span>
				<input class="form-control" required type="email" name="email" placeholder="EX: example@test.com"/>
			</div>
		</div>
		<div class="row control_type col-xs-11 col-xs-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-xs-offset-3">
			<div class="cat_select col-xs-4">
				<button id="category-btn" type="button" class="dropdown-toggle btn btn-default" data-toggle="dropdown" aria-expanded="false" aria-haspopup="true">
					Categorey
					<span class="caret"></span>
				</button>
				<ul class="dropdown-menu" id="cat_list">
					<?php
					while($rows = $stmt->fetch(PDO::FETCH_NUM)){
						echo "<li onclick='get_types(\"$rows[0]\")'><a href='javascript:void(0);'>".$rows[0]."</a></li>";
					}
					?>
				</ul>
			</div>
			<div class="cat_select col-xs-4 col-xs-offset-2">
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
			<input class="btn btn-md btn-success col-xs-6 col-xs-offset-3 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4 " type="submit" id="save_tot" value="Subscribe"/>
		</div>
	</form>