<?php
	/**
	 *	Includes all the code Needed for the Headers for Pages!
	 *
	 */

	session_start();
	if(!isset($_SESSION['user'])){
		header("Location:login.php");
		exit;
	}

	if(isset($needDB) && $needDB == true)
		include_once('./inc/dbconnect.php');

	if(!isset($pageName))
		$pageName = basename($_SERVER['PHP_SELF']); 

 ?>
 <!DOCTYPE html>
<html>
	<head>
		<title><?php echo $pageName; ?></title>
		<script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.js"></script>
		<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
