<?php

	$needDB = true;
	include('inc/header.php');


	$queryStatement = "select name, id, description from items";
	$query = $conn->prepare($queryStatement);
	$query->execute();

?>
		<style type="text/css">
			.indent {
				margin-left:50px;
			}
		</style>
	</head>
	<body>
		<?php
			include('inc/nav_bar.php');
			while($item = $query->fetch(PDO::FETCH_NUM)) {
				echo "<div class=\"indent\">";
				echo "<div class='item_details'>
					<a href=\"equipment.php?id=$item[1]\"><h4 class='item' data-id='" . $item[1] . "'>" . $item[0] . "</h3></a>
					<div class='description'> Description: " . $item[2] . "</div> 
				</div>";
				echo "</div>";
			}
		?>
	</body>
</html>
