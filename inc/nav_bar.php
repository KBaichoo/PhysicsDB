<?php


 ?>
 <h3 class="grid_12">
 	<ul>
 		<li class="grid_2">
 			<a href="index1.php">Index</a>
 		</li>
 		<li class="grid_2">
 			<a href="equipment.php">Equipment</a>
 		</li>
 		<li class="grid_2">
 			<a href='admin.php'>Administator Page</a>
 		</li>
		<?php if(isset($_SESSION['user']) && ($_SESSION['level'] == "admin") || ($_SESSION['level'] == "superadmin")){ ?>
		
			<li class="grid_2">
				<a href='admin.php?manage=accounts'>Manage Accounts</a>
			</li class="grid_2">
			<li class="grid_2">
				<a href='admin.php?manage=items'>Manage Items</a>
			</li>
		
		<?php } ?>
 		
 		<li class="grid_1">
 			<a href="logout.php">Logout</a>
 		</li>
 	</ul>
 </h3>