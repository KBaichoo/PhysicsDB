<div id="userContainer">
	<div id="createUser" class="userControl panel panel-primary">
		<h3 class="panel-heading">Create Users</h3>
		<div class="panel-body"> 
			<div class="result"></div>
			<input type="email" placeholder="email" name="email" maxlength="256"/>
			<select name="level">
				<?php

					$queryStatement = "Select distinct(level) from users where level != 'superadmin'";
					$query = $conn->prepare($queryStatement);
					$query->execute();
					while($row = $query->fetch(PDO::FETCH_NUM)){
						echo "<option value='{$row[0]}'>{$row[0]}</option>";
					}
				?>
			</select>
			<button class="btn-primary" onclick="createUser();">Create User</button>
		</div>
	</div>
	<div id="deleteUser" class="userControl panel panel-primary">
		<h3 class="panel-heading">Delete User</h3>
		<div class="result"></div>
		<?php

			$possibleUsersToModify = "select email,id from users where email != '" . $_SESSION['user'] . "' AND level != 'admin' AND level != 'superadmin'";
			if($_SESSION['level'] == "superadmin")
				$possibleUsersToModify = "select email,id from users where email != '" . $_SESSION['user'] . "'";
			
			$usersList = listOptions($possibleUsersToModify);

			?>
			<ul class="panel-body">
			<?php 	
			
				foreach ($usersList as $user) {
			?>
				<li data-user="<?php echo $user[1]; ?>" style="list-style-type:none;">
					<span href="./admin.modify.user.php?userId=<?php echo $user[1] ?>" title="<?php echo $user[0]; ?>" class="fancybox fancy.iframe" ><?php echo $user[0]; ?></span>
				</li>
			<?php

				}			
			?>
			</ul>
	</div>
</div>