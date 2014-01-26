<?php
	session_start();
	if (!isset($_SESSION['user'])) {
		header("Location:login.php");
		exit;
	}
	
	echo "You've logged in " . $_SESSION['user'];

?>
<!DOCTYPE html>
<html>
	<head>
		<title>
			Page
		</title>
		<script type="text/javascript"></script>
		<style type="text/css"></style>
	</head>
	<body>
		<div>
			<a href="equipment.php">Equipment</a>
			<a href="specificequipment.php">Specific Equipment</a>
			<a href="room.php">Search by Room</a>
			<a href='admin.php'>Administator Page</a>
			<a href="logout.php">Logout</a>

		</div>
	</body>
</html>