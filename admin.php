<?php
	$pageName = "Admin Panel";
	$needDB = true;
	include('inc/header.php');
?>

<?php
	function listOptions($queryStatement){
		global $conn;
		$query = $conn->prepare($queryStatement);
		$query->execute();
		$results = array();
		while($row = $query->fetch(PDO::FETCH_NUM)){
			$results[] = $row;
		}
		return $results;	
	}
?>
		<style type="text/css">
			#deleteBin{
				width:200px;
				height: 200px;
				background-color: red;
			}
			#currentContainer{
				width: 400px;
				height: 200px;
				background-color: blue;
			}
		</style>
		<script type="text/javascript" src="admin.js"></script>
		<script type="text/javascript">
		$(document).ready(function(){
			$("#locations").find("[name='rooms']")[0].onchange = function(){
				loadDescending("rooms","loadSections","roomId","section");
			};
			$("#locations").find("[name='section']")[0].onchange = function(){
				loadDescending("section","loadContainers","sectionId","containers");
			};
			$("#locations").find("[name='containers']")[0].onchange = function(){
				loadDescending("containers","loadEquipment","containerId","currentContainer");
			};

			$("[name='itemsList']")[0].onchange = function(){
				$("#currentItemName")[0].innerHTML = $("[name='itemsList']").find(":selected").html();
				$("#currentItem").attr("data-id",$("[name='itemsList']").find(":selected").attr("data-id"));
				var url = "ajax.php?function=itemDescription&itemId="  + $("[name='itemsList']").find(":selected").attr("data-id");
				$.get(url).done(function(data){
					$("#currentItemDescription").html(data);
				});
			};

			$("#currentItem").draggable({
				containment: '#itemManage',
				revert: 'invalid'
			});


			$("#currentContainer").droppable({
				accept: "#currentItem",
				drop: function(event,ui){
					 var _drop = $(this); 
               		 var _drag = $(ui.draggable);
               		 _drag.draggable('option','revert',true);
               		 if (_drag.find('input').val() < 1){
               		 	return;
               		 };
               		 var url = "admin.ajax.php?function=insertItem&itemId="  + _drag.attr("data-id") + "&container=" + $("[name='containers']").find(":selected").val() + "&quantity=" + _drag.find('input').val();
					$.get(url).done(function(data){
						var data = JSON.parse(data);
						if($("#currentContainer").find("[data-id='"+ data['id'] + "']").length > 0){
							$("#currentContainer").find("[data-id='"+ data['id'] + "']").remove();
						}
							$("#currentContainer").append("<span class='movable' data-id='" + data['id'] +"'>" + $("#currentItemName").html() + " X" + data['quantity'] + "</span>");
						alert("The item has been added");

					});
				}
				}
			);

			$("#deleteBin").droppable({
				accept: '.movable',
				drop: function(event,ui){
					 var _drop = $(this) 
               		 var _drag = $(ui.draggable);
               		 var itemId = _drag.attr("data-id");
               		 _drag.remove();
               		 		 
               		var url = "admin.ajax.php?function=removeItem&itemId="  + itemId + "&container=" + $("[name='containers']").find(":selected").val();
					$.get(url).done(function(data){
						alert("The item has been removed");
					});
				}
				}
			);
			

		});
		</script>
		
	</head>
	<body>
		<?php include('inc/nav_bar.php'); ?>
		<div id="outerContainer">
			<div id="modifyMyAccount">
				<div class="result"></div>
				To change your password <?php echo $_SESSION['user'] ?> simply type it here 
				<input type="password">
				<input type="password">
				<button onclick="updatePassword();">Change my password!</button>
			</div>
			<?php 
				if(isset($_SESSION['level']) == true && $_SESSION['level'] != 'teacher'){
			?>
			<div id="itemManage">
				<div id="items">
					<input name="nameOfItem" type="text" placeholder="Item Name">
					<input name="description" type="text" placeholder="Item description">
					<input name="serial" type="text" placeholder="serial number">
					<button onclick="createItem();">Create Item</button>
					<select name="itemsList">
						<?php
							$itemInfo = listOptions("Select name,id from items");
							foreach($itemInfo as $item) {
								echo "<option data-id='" . $item[1] . "' value='" . $item[0] .  "'>" . $item[0] . "</option>";
							}
						?>
					</select>
					<button onclick="deleteItem();">Delete Item</button>
					<div id="currentItem">
						<span id="currentItemName"></span>
						<span id="currentItemDescription"></span>
						<input type="number">
					</div>
				</div>
				<div id="locations">
					<select name="rooms">
						<?php 
							$rooms = listOptions("Select id,number from rooms");
							foreach($rooms as $room) {
								echo "<option value='" . $room[0] .  "'>" . $room[1] . "</option>";
							}
						 ?>
					</select>
					<select name="section">

					</select>
					<select name="containers">

					</select>
					<div id="currentContainer">

					</div>
					<div id="deleteBin">

					</div>
				</div>
			</div>
			<div id="userContainer">
				<div id="deleteUser" class="userControl">
					<div class="result"></div>
					<select name="userList" >
					<?php

						$possibleUsersToModify = "select email from users where email != '" . $_SESSION['user'] . "' AND level != 'admin' AND level != 'superadmin'";
						if($_SESSION['level'] == "superadmin")
							$possibleUsersToModify = "select email from users where email != '" . $_SESSION['user'] . "'";
						
						$usersList = listOptions($possibleUsersToModify);


						foreach ($usersList as $user) {
							echo "<option value='{$user[0]}'>{$user[0]}</option>";
						}			
					?>
					</select>
					<button onclick="deleteUser();">Delete User</button>
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
			<?php }?>
			<div>
				<?php 
					var_dump($_SESSION);
				?>
			</div>
		</div>
	<?php include('inc/footer.php'); ?>