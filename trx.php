<?php
	if(isset($_SESSION['login']) && $_SESSION['login'] == 'logged'){
		switch ($cat) {
			case 'in':
				include 'trxIn.php';
				break;

			case 'out':
				include 'trxOut.php';
				break;

			default:
				header('Location: ./');
	    }
	}
?>