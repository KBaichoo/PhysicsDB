<?php


 ?>
 <h3 class="grid12">
 	This is nav bar!
 	<ul>
 		<li>
 			<a href="index1.php">Index</a>
 		</li>
 		<li>
 			<a href="equipment.php">Equipment</a>
 		</li>
 		<li>
 			<a href='admin.php'>Administator Page</a>
 			<?php if(isset($_SESSION['user']) && ($_SESSION['level'] == "admin") || ($_SESSION['level'] == "superadmin")){ ?>
 			<ul>
 				<li>
 					<a href='admin.php?manage=accounts'>Manage Accounts</a>
 				</li>
 				<li>
 					<a href='admin.php?manage=items'>Manage Items</a>
 				</li>
 			</ul>
 			<?php } ?>
 		</li>
 		<li>
 			<a href="logout.php">Logout</a>
 		</li>
 	</ul>
 </h3>