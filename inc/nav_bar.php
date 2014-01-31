<?php


 ?>
 <h3 class="grid_12">
 	<ul>
 		<li>
 			<a href="index1.php">Index</a>
 		</li>
 		<li>
 			<a href="equipment.php">Equipment</a>
 		</li>
 		<li>
 			<a href='admin.php'>Administator Page</a>
 		</li>
		<?php if(isset($_SESSION['user']) && ($_SESSION['level'] == "admin") || ($_SESSION['level'] == "superadmin")){ ?>
		
			<li>
				<a href='admin.php?manage=accounts'>Manage Accounts</a>
			</li>
			<li>
				<a href='admin.php?manage=items'>Manage Items</a>
			</li>
		
		<?php } ?>
 		
 		<li>
 			<a href="logout.php">Logout</a>
 		</li>
 	</ul>
 </h3>