<?php
	//Check if the Session exists, then redirect user to home page
	//Make sure start the session first before accessing $_SESSION
	if(isset($_SESSION) == false) {
		session_start();
	}
	$has_Cookie_DisplayName = isset($_COOKIE["COOKIE_DISPLAYNAME"]);
	if(isset($_SESSION) == false) {
		session_start();
	}
	$has_Cookie_DisplayName = isset($_COOKIE["COOKIE_DISPLAYNAME"]);
	if($has_Cookie_DisplayName == true) {
		//if there is a cookie's value from previous login, then load the value into session.
		$_SESSION["SESS_DISPLAYNAME"] = $_COOKIE["COOKIE_DISPLAY"];
	}

	if(isset($_SESSION['SESS_DISPLAYNAME'])){
		header("Location: logcall.php");
	}

	$isLoginButtonClicked = isset($_POST["btnSubmit"]);
	if($isLoginButtonClicked == true){
		$userName = $_POST["tbUsername"];
		$password = $_POST["tbPassword"];
		
		if($userName == "pessadmin" && $password== "pessadmin1"){
			$_SESSION["SESS_DISPLAYNAME"] = "Admin";
			
			$rememberMeChecked = isset($_POST["cbRemember"]);
			if($rememberMeChecked == true) {
				//will set the cookie to expire in 30 days
				//If set to 0, or not specificed, the cookie will expire at the end of the session (when the browser closes).
				$expireTime = time() + 60 * 60 * 24 * 30;
				setcookie("COOKIE_DISPLAYNAME", "David", $expireTime);
			}
			header("Location: logcall.php");
		}
		else {
			echo "<span style='color:red'>Wrong Username / password </span>";
		}
	}
?>
<!doctype html>
<html>
<head>
<title>Login</title>
</head>

<body>
	<h2>Police Login</h2>
	<p>Please enter your username and password to log into the website.</p>
	</p>
	<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
		<table>
			<tbody>
				<tr>
					<td>Username</td>
					<td><input type="textbox" name="tbUsername" id="tbUsername" /></td>
				</tr>
				<tr>
					<td>Password</td>
					<td><input type="password" name="tbPassword" id="tbPassword" /></td>
				</tr>
				<tr>
					<td></td>
					<td><input type="checkbox" name="cbRememberMe" id="cbRememberMe" value="Yes" />Remeber Me</td>
				</tr>
				<tr>
					<td></td>
					<td><input type="submit" name="btnSubmit" id="btnSubmit" value="Log in" /></td>
				</tr>
			</tbody>
		</table>
	</form>
</body>
</html>
