<html>
<?php
	$old_user = $_SESSION['user']; 
	$_SESSION = array();
	if (isset($_COOKIE[session_name()])) {
		setcookie(session_name(), '', time()-42000, '/'); 
	}
   session_destroy();
?>
<a href="results.php">Home page</a>
</html>