<?php
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
?>