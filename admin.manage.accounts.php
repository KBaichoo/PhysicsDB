<div id="userContainer">
	<div id="deleteUser" class="userControl">
		<div class="result"></div>
		<?php

			$possibleUsersToModify = "select email from users where email != '" . $_SESSION['user'] . "' AND level != 'admin' AND level != 'superadmin'";
			if($_SESSION['level'] == "superadmin")
				$possibleUsersToModify = "select email from users where email != '" . $_SESSION['user'] . "'";
			
			$usersList = listOptions($possibleUsersToModify);

			?>
			<ul>
			<?php 	
			
				foreach ($usersList as $user) {
			?>
				<li data-user="<?php echo $user[0]; ?>">
					<?php echo $user[0]; ?>
					<span onclick="deleteUser(this);">X</span>
				</li>

			<?php

				}			
			?>
			</ul>
	</div>
	<div id="createUser" class="userControl">
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
		<button onclick="createUser();">Create User</button>
	</div>
</div>