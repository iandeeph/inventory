<?php
ob_start();
ini_set("display_errors", "1");
error_reporting(E_ALL ^ E_DEPRECATED);
session_start();

require "sql/connect.php";
require "php/inventory.php";

foreach($_POST as $key => $val) {
	if (!is_array($val)) {
		$_POST[$key] = mysql_real_escape_string($val);
	}
}
?>
<!DOCTYPE html>
<html>
	<head>
		<!--Import Google Icon Font-->
		<link href="css/material-icon.css" rel="stylesheet">
		<link href='https://fonts.googleapis.com/css?family=Kaushan+Script|Quattrocento+Sans' rel='stylesheet' type='text/css'>

		<!--Import materialize.css-->
		<link type="text/css" rel="stylesheet" href="css/materialize.css"  media="screen,projection"/>
		<link rel="stylesheet" href="css/style.css">
		<!-- favicon -->
		<link rel="apple-touch-icon" sizes="57x57" href="icon/apple-icon-57x57.png">
		<link rel="apple-touch-icon" sizes="60x60" href="icon/apple-icon-60x60.png">
		<link rel="apple-touch-icon" sizes="72x72" href="icon/apple-icon-72x72.png">
		<link rel="apple-touch-icon" sizes="76x76" href="icon/apple-icon-76x76.png">
		<link rel="apple-touch-icon" sizes="114x114" href="icon/apple-icon-114x114.png">
		<link rel="apple-touch-icon" sizes="120x120" href="icon/apple-icon-120x120.png">
		<link rel="apple-touch-icon" sizes="144x144" href="icon/apple-icon-144x144.png">
		<link rel="apple-touch-icon" sizes="152x152" href="icon/apple-icon-152x152.png">
		<link rel="apple-touch-icon" sizes="180x180" href="icon/apple-icon-180x180.png">
		<link rel="icon" type="image/png" sizes="192x192"  href="icon/android-icon-192x192.png">
		<link rel="icon" type="image/png" sizes="32x32" href="icon/favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="96x96" href="icon/favicon-96x96.png">
		<link rel="icon" type="image/png" sizes="16x16" href="icon/favicon-16x16.png">
		<link rel="manifest" href="icon/manifest.json">
		<meta name="msapplication-TileColor" content="#ffffff">
		<meta name="msapplication-TileImage" content="icon/ms-icon-144x144.png">
		<meta name="theme-color" content="#ffffff">
		<!-- tyni mce -->
		<script src='js/tinymce/tinymce.min.js'></script>
		<!--Let browser know website is optimized for mobile-->
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<title>Cermati inventory</title>
	</head>
  <body>
		<header>
			<div class="navbar-fixed grey darken-3">
				<nav class="grey darken-3">
					<div class="nav-wrapper navbar-fixed grey darken-3 valign-wrapper left-menu">
							<?php
								if(isset($_SESSION['login']) && $_SESSION['login'] == 'logged' && $_SESSION['privilege'] == '1'){
									?>
										<a href="#" data-activates="side-menu" class="button-collapse left ml-30"><i class="menu-side-icon material-icons">menu</i></a>
									<?php
								}
							?>
						<a href="./" class="center brand-logo"><img class="admin-logo mt-10" src="images/cermati.png"></a>
						<div style="width:100%" class="hide-on-med-and-down"><span class="font-open-sans right mr-30 font-40">Cermati Inventory</span></div>
					</div>
				</nav>
			</div>
		  	<?php
		  		if(isset($_SESSION['login']) && $_SESSION['login'] == 'logged'){
		  			$name = $_SESSION['name'];
		  			?>
						<ul id="side-menu" class="side-nav fixed">
							<li class="bold valign-wrapper" disabled>Hi, <?php echo $name;?></li>
							<li class="divider"></li>
							<li class="bold <?php echo ($menu == 'item')? "active" : "";?>"><a href="./index.php?menu=item"><i class="menu-side-icon material-icons mt-20 left">laptop</i>Item</a></li>
							<li class="bold no-padding" <?php echo ($menu == 'rekap')? "active" : "";?>>
								<ul class="collapsible" data-colapsible="accordion">
								  <li class=" <?php echo ($menu == 'rekap')? "active" : "";?>">
								    <a class="collapsible-header <?php echo ($menu == 'rekap')? "active" : "";?>"><i class="menu-side-icon material-icons left">content_paste</i>Rekapitulasi</a>
								    <div class="collapsible-body">
								      <ul>
								        <li class="bold <?php echo ($menu == 'rekap' && $cat == 'item')? "active" : "";?>"><a href="./index.php?menu=rekap&cat=item">By Items</a></li>
								        <li class="bold <?php echo ($menu == 'rekap' && $cat == 'user')? "active" : "";?>"><a href="./index.php?menu=rekap&cat=user">By User</a></li>
								      </ul>
								    </div>
								  </li>
								</ul>
							</li>
							<li class="bold <?php echo ($menu == 'user')? "active" : "";?>"><a href="./index.php?menu=user"><i class="menu-side-icon material-icons mt-20 left">person</i>User</a></li>
							<?php
								if($_SESSION['privilege'] == '1'){
									?>
										<li class="bold <?php echo ($menu == 'admin')? "active" : "";?>"><a href="./index.php?menu=admin"><i class="menu-side-icon material-icons mt-20 left">security</i>Admin User</a></li>
										<li class="bold <?php echo ($menu == 'log')? "active" : "";?>"><a href="./index.php?menu=log"><i class="menu-side-icon material-icons mt-20 left">save</i>Activity Log</a></li>
									<?php
								}
							?>
							<li class="divider"></li>
							<li class="bold"><a href="./index.php?menu=logout"><i class="menu-side-icon material-icons mt-20 left">power_settings_new</i>Logout</a></li>
						</ul>
					<?php
				}else{
			    	include 'login.php';
			    }
			?>
		</header>
    <main>
    	<div class="menu-admin">
		    <?php
		  		if(isset($_SESSION['login']) && $_SESSION['login'] == 'logged'){
					switch ($menu) {
						case 'log':
							include 'log.php';
							break;

						case 'item':
							include 'item.php';
							break;

						case 'rekap':
							include 'rekap.php';
							break;

						case 'trx':
							include 'trx.php';
							break;

						case 'user':
							include 'user.php';
							break;

						case 'logout':
							include 'logout.php';
							break;

						case 'admin':
							include 'admin.php';
							break;

						default:
							include 'akumulasi.php';
							break;
			        }
			    }
		    ?>
    	</div>
    </main>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
    <script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="js/materialize.min.js"></script>
    <script type="text/javascript" src="js/inventory.js"></script>
  </body>
</html>