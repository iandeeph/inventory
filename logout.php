<?php
	$logingContentText = "Username : ".$_SESSION['username']."<br>Name : ".$_SESSION['name'];
	logging($now, $_SESSION['username'], "User Logout", $logingContentText, $_SESSION['iduser']);
	session_destroy();
	header('Location: ./');
?>