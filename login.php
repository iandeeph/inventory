<?php
	$colorLoginNotif	= '';
	$textLoginNotif		= '';

	if(isset($_POST['btnLogin'])){
		$postUsername = $_POST['loginUsername'];
		$postPassword = $_POST['loginPassword'];

		$loginQry = "SELECT * FROM admin WHERE username = '".$postUsername."' AND password = '".$postPassword."' LIMIT 1";
		if($resultLogin = mysql_query($loginQry)){
			if (mysql_num_rows($resultLogin) != 0) {
				$rowLogin = mysql_fetch_array($resultLogin);
				$_SESSION['login']  	= 'logged';
				$_SESSION['name']  		= $rowLogin['name'];
				$_SESSION['privilege']  = $rowLogin['privilege'];
				$_SESSION['idadmin']	= $rowLogin['idadmin'];
				$_SESSION['username']	= $rowLogin['username'];

				$logingContentText = "Username : ".$rowLogin['username']."<br>Name : ".$rowLogin['name'];
    			logging($now, $postUsername, "User Login Success", $logingContentText, $rowLogin['idadmin']);
				header('Location: ./');
			}else{
				$_SESSION['login']	= 'notlogged';
				$colorLoginNotif	= 'red-text';
				$textLoginNotif		= 'Username or Password Wrong..';
			}
		}
	}
?>
<div class="row">
	<div class="col s12">
		<div class="login-panel col offset-m3 offset-l4 s12 m6 l4 z-depth-5 mt-30">
			<form action="#" method="post" enctype="multipart/form-data">
				<div class="col s12 blue-text text-darken-4 center hide-on-med-and-up mt-20">
					<h5>CERMATI INVENTORY</h5>
				</div>
				<div class="col s12 center">
					<h4>LOGIN</h4>
				</div>
				<div class="input-field col s12">
					<input id="loginUsername" name="loginUsername" type="text" class="validate" required>
					<label for="loginUsername">Username</label>
				</div>
				<div class="input-field col s12">
					<input id="loginPassword" name="loginPassword" type="password" class="validate" required>
					<label for="loginPassword">Password</label>
				</div>
				<div class="input-field col s12">
					<button type="submit" name="btnLogin" class="waves-effect waves-light btn black right"><i class="material-icons left">send</i>Login</button>
				</div>
				<div class="input-field col s12 mb-10">
					<span class="<?php echo $colorLoginNotif; ?>"><?php echo $textLoginNotif; ?></span>
				</div>
			</form>
		</div>
	</div>
</div>