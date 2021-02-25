<!doctype html>
<html>
<body>
	<h2>Home</h2>
	<?php
		$has_Cookie_DisplayName = isset($_COOKIE["COOKIE_DisplayName"]);
		if($has_Cookie_DisplayName == true) {
			$_cookie_Displayname = $_COOKIE["COOKIE_DisplayName"];
			echo "Welcome <strong>" . $_cookie_DisplayName . "!</strong> [<a href='logout.php'>logout</a>]";
		}
		else {
			if(isset($_SESSION) == false){
				session_start();
			}
			//Check for Session
			$has_Session_DisplayName = isset($_SESSION["SESS_DISPLAYNAME"]);
			if($has_Session_DisplayName == true) {
				$session_DisplayName = $_SESSION["SESS_DISPLAYNAME"];
				echo "Welcome <strong>" . $session_DisplayName . "!</strong> [<a href='logout.php'>logout</a>]";
			}
			else {
				echo "<a href='login.php'>Login</a>";
			}
		}
	?>
</body>
</html>