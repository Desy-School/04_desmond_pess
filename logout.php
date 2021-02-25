<?php
	if(isset($_SESSION) == false){
		session_start();
	}
	$has_Session_DisplayName = isset($_SESSION["SESS_DISPLAYNAME"]);
	if ($has_Session_DisplayName == true) {
		$_SESSION["SESS_DISPLAYNAME"] = null;
		session_destroy();
	}
	$has_Cookie_DisplayName = isset($_COOKIE["COOKIE_DISPLAYNAME"]);
	if ($has_Cookie_DisplayName == true) {
		unset($_COOKIE["COOKIE_DISPLAYNAME"]);
		// As an extra safety measure, you should also set the expiration time to a time in the past
		// -1 as you can see below where we pass in "-1" for the expiration date to invalidate it
		setcookie("COOKIE_DISPLAYNAME", null, -1);
	}
	header("Location: login.php")
?>