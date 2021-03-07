<!doctype html>
<html>
<head>
<title>Login</title>
<link href="css/bootstrap-4.4.1.css" rel="stylesheet" type="text/css">
</head>

<body>
	<div class="container" style="width:900px">
	<h2 class="mt-5">Police Login</h2>
	<p >Please enter your username and password to log into the website.</p>
	</p>
	<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
	<?php
	//Check if the Session exists, then redirect user to home page
	//Make sure start the session first before accessing $_SESSION
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
	error_reporting(0);

		
	$isLoginButtonClicked = isset($_POST["btnSubmit"]);
	if($isLoginButtonClicked == true){
		$userName = $_POST["tbUsername"];
		$password = $_POST["tbPassword"];
	require_once "db.php";
	$conn = new mysqli(DB_SERVER,DB_USER,DB_PASSWORD,DB_DATABASE);
	$result = mysqli_query($conn, "SELECT * FROM USERS WHERE `USERNAME` = '$userName' AND `PASSWORD` = '$password'") or die( mysqli_error($conn));
	$row = mysqli_fetch_array($result);
	if ($row['username'] !== NULL && $row['username'] == $userName && $row['password'] == $password){
			$_SESSION["SESS_DISPLAYNAME"] = $userName;
			$rememberMeChecked = isset($_POST["cbRemember"]);
			if($rememberMeChecked == true) 
			{
				//will set the cookie to expire in 30 days
				//If set to 0, or not specificed, the cookie will expire at the end of the session (when the browser closes).
				$expireTime = time() + 60 * 60 * 24 * 30;
				setcookie("COOKIE_DISPLAYNAME", "pessadmin", $expireTime);
			}
			header("Location: logcall.php");
		}
		else 
		{
			echo "<span style='color:red'>Wrong Username / password </span>";
		}
	}
?>
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
	</div>
	<script src="js/jquery-3.4.1.min.js"></script> 
	<script src="js/popper.min.js"></script> 
	<script src="js/bootstrap-4.4.1.js"></script>
</body>
</html>
