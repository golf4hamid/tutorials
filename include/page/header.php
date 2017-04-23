<?php
	/* Here Goes The Header Of All Pages */
require_once('include/db/DB_login.php');
?>
<div class="container">  <!--header-->
	<nav class="nav-bar navbar-default"> <!--Navigation_bar-->
        <div class="navbar-header">
            <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar">
                <span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
                <span class="sr-only">Toggle Navidation Bar</span>
            </button>
            <a href="#" class="navbar-brand logo" onclick="goto_page('include/page/main.php', 'call', 'yes'); return false;">Online Tutorials<!--logo--></a>
        </div>
		<div class="collapse navbar-collapse" id="navbar">
            <ul class="nav navbar-nav">
                <li class="dropdown"><a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">Categories
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <?php
                            try{
                                $conn = new PDO("mysql:host=$db_host; dbname=$db_db", $db_user, $db_pass, array(PDO::ATTR_PERSISTENT => true));
                                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                $stmt = $conn->prepare("SELECT name FROM categories");
                                $stmt->execute();
                                while($r = $stmt->fetch(PDO::FETCH_NUM)) {
                                    $con = "<li onclick='refer(\"$r[0]\", \"cat\")'>"; # class='cat_links'
                                    $con .= "<a href='javascript:void(0)' class='cat_link'>";
                                    $con .= "$r[0]</a></li>";
                                    echo $con;
                                }
                            }catch(PDOException $err){

                            }
                        ?>
                    </ul>
                </li>
                <li class="dropdown"><a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown"> Services
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li onmouseenter="loadModal('include/page/ask_for_tut.php')" data-toggle='modal' data-target='#myModal'>
                            <a href="javascript:void(0);">Ask For a Tutorial</a>
                        </li>
                    </ul>
                </li>
                <li><a href="javascript:void(0);" onmouseenter="loadModal('include/page/contact_us.php')" data-toggle='modal' data-target='#myModal'>Contact Us</a></li>
            </ul>
            <form class="navbar-form navbar-right search-form" onsubmit="search(); return false;">
                <div class="form-group input-group">
                    <input type="text" name='query' class="form-control input-control" placeholder="Search For ..."/>
                    <span class="input-group-btn"><button type="submit" class="btn btn-default">Search</button></span>
               </div>
           </form>
        </div>
	</nav>
</div> <!--End Of header-->
