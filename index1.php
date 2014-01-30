<?php

	include('inc/header.php');
	
	echo "You've logged in " . $_SESSION['user'];

?>
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