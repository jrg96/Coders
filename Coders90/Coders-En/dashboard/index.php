<!--                Copyright (c) 2014 
José Fernando Flores Santamaría <fer.santamaria@programmer.net>
#
# This program is free software: you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation, either version 3 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with this program. If not, see <http://www.gnu.org/licenses/>.
-->
<?php
	session_save_path("../sessions/");
	session_start();
	error_reporting(0);
	if(!isset($_SESSION['UserID'])){
		header('Location: ../');
	}

	if(isset($_POST["btnPost"])){
		$user=$_SESSION['UserID'];
		$content=$_POST["PContent"];

		date_default_timezone_set("America/El_Salvador");

		$pdate=date("Y-m-d");
		$phour=date("H:i:s");

		$pid=$_SESSION['UserID'].date("Ymdhis");	

		include("../BDD.php");
		$post="INSERT INTO post VALUES ('$pid','$user','$content','$pdate','$phour','1')";
		$result=mysql_query($post,$dbconn);

		if ($result) {
			header("location:../dashboard/");
		}
	}
	require("../SQLFunc.php");
?>	
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<title>Coders {}</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
	<meta name="description" content="La primera comunidad de programadores de El">
	<meta name="author" content="Fernando Santamaría - Christian Zayas">
	<!-- STYLESHEETS --><!--[if lt IE 9]><script src="../js/flot/excanvas.min.js"></script><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script><![endif]-->
	
	<link rel="stylesheet" type="text/css" href="../css/style.css" >
	<link rel="stylesheet" type="text/css"  href="../css/themes/default.css">
	<link rel="stylesheet" type="text/css"  href="../css/responsive.css" >
	<link rel="stylesheet" href="../editor/jquery-ui/css/coders/jquery-ui-1.10.4.custom.css">

	<script src="../editor/jquery-ui/js/jquery-1.10.2.js"></script>
	<script src="../editor/jquery-ui/js/jquery-ui-1.10.4.js"></script>

	<link href="../font-awesome/css/font-awesome.min.css" rel="stylesheet">
	<!-- FONTS -->
	<link href='../css/fonts.css' rel='stylesheet' type='text/css'>
	<!-- Favicon -->
	<link rel="shortcut icon" href="../common/img/favicon.png" />
</head>
<body>
<div class="overlay-content" id='loader-div'>
	<center><p class="overlay-icon"><i class="fa fa-spinner fa-spin"></i></p></center>
</div>
<!-- Header de Pagina -->
<header class="navbar clearfix navbar-fixed-top" id="header">
	<div class="container">
		<div class="navbar-brand">
			<!-- Logo Proyecto -->
			<a href="../dashboard/">
				<img src="../img/logo/logo.png" alt="Coders Logo" class="img-responsive" height="30" width="120">
			</a>
			<!-- /Logo Proyecto -->
			<!-- Ocultar Menú -->
			<div id="sidebar-collapse" class="sidebar-collapse btn">
				<i class="fa fa-bars" 
					data-icon1="fa fa-bars" 
					data-icon2="fa fa-bars"></i>
			</div>
			<!-- /Ocultar Menu -->
		</div>
		
		<!-- General Menu -->					
		<ul class="nav navbar-nav pull-right">
			<!-- Notifications -->
			<li class="dropdown" id="header-notification">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">
					<i class="fa fa-bell"></i>
					<span class="badge"><?php echo numberNotifications();?></span>						
				</a>
				<ul class="dropdown-menu notification" id="notifications">
					<li class="dropdown-title">
						<span><i class="fa fa-bell"></i>Notifications</span>
					</li>
					<?php
					notifList();
					?>
					<li class="footer">
						<a href="../notifications/">See all notifications  <i class="fa fa-arrow-circle-right"></i></a>
					</li>
				</ul>
			</li>
			<!-- /Notifications -->
			<!-- User Menu -->
			<li class="dropdown user" id="header-user">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">
					<img alt="" src="../img/avatars/<?php echo $_SESSION['UserID'];?>.jpg" onerror="this.src='../img/avatars/default.jpg'"/>
					<span class="username"><?php echo $_SESSION['UserName']." ".$_SESSION['UserLast'];?></span>
					<i class="fa fa-angle-down"></i>
				</a>
				<ul class="dropdown-menu">
					<li><a href="../profile/"><i class="fa fa-user"></i> My profile</a></li>
					<?php 
						if ($_SESSION['Admin']=="1") {
							echo"<li><a href='../admin/dashboard/'><i class='fa fa-wrench'></i> Administration Panel</a></li>";
						} else {
							echo "";
						}
					?>
					<li><a href="../user/"><i class="fa fa-cog"></i> Settings</a></li>
					<li><a href="../logout/index.php"><i class="fa fa-power-off"></i> log Out</a></li>
				</ul>
			</li>
			<!-- /User Menu -->
		</ul>
		<!-- /General Menu -->
	</div>
</header>
<!--/HEADER -->

<!-- Contenido General -->
<section id="page">
			<!-- Menu de navegacion -->
			<div id="sidebar" class="sidebar sidebar-fixed">
				<div class="sidebar-menu nav-collapse">
					<div class="divide-20"></div>
					<div id="search-bar">
						<input type="text" id="searchbar" class="search" autocomplete="off" placeholder="Name - Last Name - Email"><i class="fa fa-search search-icon"></i>
					</div>
					<div id="targetDiv" class="search-div search-box">
					</div>
					<!-- Opciones de menu -->
					<ul>
						<li>
							<a href="../dashboard/">
								<i class="fa fa-tachometer fa-fw"></i> <span class="menu-text">Dashboard</span>
							</a>					
						</li>
						<li>
							<a href="../workspace/">
								<i class="fa fa-desktop fa-fw"></i> <span class="menu-text">Worskpace</span>
							</a>
						</li>
						<li>
							<a href="../messages/">
								<i class="fa fa-envelope fa-fw"></i><span class="menu-text">Messages
								</span>
							</a>
						</li>
						<li>
							<a href="../editor/">
								<i class="fa fa-file-text fa-fw"></i><span class="menu-text">Code Editor
								</span>
							</a>
						</li>
						<li>
							<a href="../groups/">
								<i class="fa fa-group fa-fw"></i><span class="menu-text">Groups
								</span>
							</a>
						</li>
					</ul>
					<!-- /Opciones de menu -->
				</div>
			</div>
			<!-- /Menu de navegación -->
	<div id="main-content">
		<div class="container pull-left">
			<div class="row">
				<div id="content" class="col-lg-12">
					<!-- Header de contenido-->
					<div class="row">
						<div class="col-sm-12">
							<div class="page-header">
								<!-- BREADCRUMBS -->
								<ul class="breadcrumb">
									<li>
										<i class="fa fa-home"></i>
										<a href="../dashboard/">Home</a>
									</li>
								</ul>
								<!-- /BREADCRUMBS -->
								<div class="clearfix">
									<h3 class="content-title pull-left">
										<span><</span>
										<span>CODERS</span>
										<span>/</span>
										<span>></span>
									</h3>
								</div>
								<div class="description">One line of code can change the world!</div>
							</div>
						</div>
					</div>
					<!-- /Header de contenido -->
					<!-- Contenido general -->
					<div class="row">
						<div class="col-xs-12 col-md-12 pull-right">
							<!-- Post-->
							<div class="box border blue">
						    	<div class="box-title small">
									<h4><i class="fa fa-code"></i>What's on your mind?</h4>
								</div>
								<div class="box-body clearfix" style="word-wrap:break-word;">
									<span>
										<form method="post" action="index.php">
											<div class="col-xs-2 col-md-1"> 
												<img class="img-perfil" src="../img/avatars/<?php echo $_SESSION['UserID'];?>.jpg" onerror="this.src='../img/avatars/default.jpg'" width="50" height="50">
											</div>
											<div class="col-xs-10 col-md-11">
												<div class="col-xs-12 col-md-12" style="word-wrap:break-word;">
													<textarea class="form-control" rows="4" name="PContent" id="PContent"></textarea>
												</div>
												<div class="col-xs-12 col-md-6 pull-right">
													<center></br><input name="btnPost" id="btnPost" type="submit" class="btn btn-primary col-xs-12 col-md-4 pull-right" value="Code it!"/></center></br>
												</div>
												<div class="col-xs-12 col-md-6 pull-left">
													</br>
													<h4>
														<span><</span>
														<span>CODERS</span>
														<span>/</span>
														<span>></span>
													</h4>
												</div>
											</div>
										</form> 
									</span>
								</div>
							</div>
							<!-- /Post-->
							<div id="newsFeed">
							<?php 
							NewsFeed();
							?>
							</div>
						</div>
					</div>
					<!-- /Contenido general --> 
				</div>
			</div>
		</div>
	</div>
</section>
<div id="dialog-confirm-comment" title="Coders" style="display:none">
  <p><h3><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></h3></span>Are you sure you want to delete this?</p>
</div>
<div id="dialog-confirm-post" title="Coders" style="display:none">
  <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span><br>Are you sure you want to delete this?</p>
</div>
<!-- Core Bootstrap-->
<!--/PAGE -->
<!-- JAVASCRIPTS -->
<script type="text/javascript">
	var idf=null;

	$( ".fa-comments" ).click(function() {
		var idf = $(this).attr("idf");
		getData('comments.php',idf,idf);				
	});

	function postComment(e){
		var idf=$("."+$(e).attr("idf")).val();
		var postIdf=$(e).attr("idf");

		if(idf!=""){
	       $.post("userActions.php", 
	              {contents: idf, postidf: postIdf, action: "postComment"},
	              function() {
	                  getData('comments.php',postIdf,postIdf);
	              }
	        );
	    } else {
	      return false;
	    }
	}

	function delComment(e){
		$( "#dialog-confirm-comment" ).dialog({
	      resizable: false,
	      height:180,
	      width: 400,
	      modal: true,
	      buttons: {
	        "Borrar": function (){
	          $( this ).dialog( "close" );
	            var idf=$(e).attr("idf");
				var postIdf=$(e).attr("post-idf");
				$.post("userActions.php", 
		              {idf: idf, action: "delComment"},
		              function() {
		              	  getData('comments.php',postIdf,postIdf);
		              }
		        );
	        },
	        Cancelar: function() {
	          $( this ).dialog( "close" );
	        }
	      }
	    });				
	}

	function delPost(e){
		$( "#dialog-confirm-post" ).dialog({
	      resizable: false,
	      height:180,
	      width: 400,
	      modal: true,
	      buttons: {
	        "Borrar": function (){
	          $( this ).dialog( "close" );
	            var idf=$(e).attr("idf");
				$.post("userActions.php", 
		              {idf: idf, action: "delPost"},
		              function() {
		              	  location.reload();
		              }
		        );
	        },
	        Cancelar: function() {
	          $( this ).dialog( "close" );
	        }
	      }
	    });				
	}

	$( "#searchbar" ).keyup(function(){
		var text = $( "#searchbar" ).val();
		var text2=$.trim(text);

		if (text2!="" && text.length>2) {
			getData('cons.php', 'targetDiv',tag());
		} else {
			$("#targetDiv").html("");
		};
	});
</script>
<!-- JQUERY -->
<!-- AJAX -->
<script src="../Func.js"></script>
<!-- BOOTSTRAP -->
<script src="../bootstrap-dist/js/bootstrap.min.js"></script>
<!-- SLIMSCROLL -->
<script type="text/javascript" src="../js/jQuery-slimScroll-1.3.0/jquery.slimscroll.min.js"></script><script type="text/javascript" src="../js/jQuery-slimScroll-1.3.0/slimScrollHorizontal.min.js"></script>
<!-- COOKIE -->
<script type="text/javascript" src="../js/jQuery-Cookie/jquery.cookie.min.js"></script>
<!-- CUSTOM SCRIPT -->
<script src="../js/script.js"></script>
<script>
	jQuery(document).ready(function() {	
		App.init(); //Initialise plugins and elements
	});
</script>
<!-- /JAVASCRIPTS -->
</body>
</html>