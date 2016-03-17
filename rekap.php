<?php
	if(isset($_SESSION['login']) && $_SESSION['login'] == 'logged'){
		switch ($cat) {
			case 'item':
				include 'byitem.php';
				break;

			case 'user':
				include 'byuser.php';
				break;

			default:
				header('Location: ./');
	    }
	}
?>