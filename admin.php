<?php
	session_start();
	if(!isset($_SESSION['user'])){
		header("Location:index1.php");
		exit;
	}
	include('./inc/dbconnect.php');
	

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
<!DOCTYPE html>
<html>
	<head>
		<title>Admin Page</title>
		<script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.js"></script>
		<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
		<style type="text/css">
			#deleteBin{
				width:200px;
				height: 200px;
				background-color: red;
			}
		</style>
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

		function loadDescending(nameOfCurrentLevel,func,id,nameOfDescendingSelect){
			$("[name='" + nameOfDescendingSelect +"']").empty();
			if(nameOfDescendingSelect == "currentContainer"){
				$("#" + nameOfDescendingSelect).empty();
			}
			var t = $("#locations").find("[name='" + nameOfCurrentLevel +"']");
			var url = "ajax.php?function=" + func + "&" + id + "=" + encodeURIComponent(t.find(":selected").val());
			$.get(url).done(function(data){
					var infomation = JSON.parse(data);
				switch(id){
					case 'roomId':
						for (var i = 0; i < infomation.length; i++) {
							$("[name='" + nameOfDescendingSelect +"']").append("<option value='" + infomation[i]['id'] + "'>" + infomation[i]['name'] +"</option>");
						};
						break;
					case 'sectionId':
						for (var i = 0; i < infomation.length; i++) {
							$("[name='" + nameOfDescendingSelect +"']").append("<option value='" + infomation[i]['id'] + "'>" + infomation[i]['label'] +"</option>");
						};
						break;
					case 'containerId':
						for (var i = 0; i < infomation.length; i++) {
							$("#" + nameOfDescendingSelect).append("<span class='movable' data-id='" + infomation[i]['id']  + "'>" + infomation[i]['name'] + "  X" + infomation[i]['quantity'] +"</span>");
						};
						$(".movable").draggable({
							containment: '#itemManage'
						});
						break;
					default:
						break;
				}	
			});
		}

		function createUser(){
			var email = $('#createUser').find("[name='email']")[0];
			var level = $('#createUser').find("[name='level']")[0];
			
			var url = "admin.ajax.php?function=createUser&email=" + encodeURIComponent(email.value) + "&level=" + encodeURIComponent(level.value);
					$.get(url).done(function(data){
						($('#createUser').find('.result')[0]).innerHTML = data;
						//There is an error code(usually 23000 meaning users added already)
						if(!isNaN(parseInt(data))){
							($('#createUser').find('.result')[0]).innerHTML = "The user already exists!";
						}
					}).fail(function(data){
						($('#createUser').find('.result')[0]).innerHTML = "There was an MAJOR ERROR!";
					});
		}

		function deleteUser(){
			var accountToBeDeleted = $("[name='userList']")[0].value;
			var url = "admin.ajax.php?function=deleteUser&email=" + encodeURIComponent(accountToBeDeleted);
			$.get(url).done(function(data){
				($('#deleteUser').find('.result')[0]).innerHTML = data;
				$("[name='userList']")[0].remove($("[name='userList']")[0].selectedIndex);
			}).fail(function(data){
				($('#deleteUser').find('.result')[0]).innerHTML = "There was an MAJOR ERROR!";
			});
		}

		function updatePassword(){
			var passwords = $("[type='password']");
			if(passwords[0].value != passwords[1].value){
				$("#modifyMyAccount").find('.result')[0].innerHTML = "The Passwords Don't Match!";
				return;
			}
			var url = "admin.ajax.php?function=updatePassword&password=" + encodeURIComponent(passwords[0].value);
			$.get(url).done(function(data){
				($('#modifyMyAccount').find('.result')[0]).innerHTML = data;
			}).fail(function(data){
				($('#deleteUser').find('.result')[0]).innerHTML = "There was an MAJOR ERROR!";
			});

		}

		function createItem(){
			var itemName = $("#items").find("[name='nameOfItem']")[0].value;
			var description = $("#items").find("[name='description']")[0].value;
			var serial = $("#items").find("[name='serial']")[0].value;
			if(itemName == ""){
				return;
			}
			var url = "admin.ajax.php?function=createItem&name=" + encodeURIComponent(itemName) + "&description=" + encodeURIComponent(description) + "&serial=" + encodeURIComponent(serial);
			$.get(url).done(function(data){
				alert("You made a " + itemName);
				$("[name='itemsList']").append("<option data-id='" + data + "' value='" + itemName + "'>" + itemName +"</option>"); 
			});
		}

		function deleteItem(itemId){
			var itemId = $("[name='itemsList']").find(":selected").attr("data-id");
			var url = "admin.ajax.php?function=deleteItem&itemId=" + encodeURIComponent(itemId);
			$.get(url).done(function(data){
				alert("It has been deleted");
				$("[name='itemsList']")[0].remove($("[name='itemsList']").find("[data-id='" + data + "']")); 
			});
		}
		</script>
		
	</head>
	<body>
		<div id="outerContainer">
			<div id="modifyMyAccount">
				<div class="result"></div>
				To change your password <?php echo $_SESSION['user'] ?> simply type it here 
				<input type="password">
				<input type="password">
				<button onclick="updatePassword();">Change my password!</button>
			</div>
			<?php 
				if(isset($_SESSION['level']) == true && $_SESSION['level'] == 'admin'){
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
						$usersList = listOptions("select email from users where email != '" . $_SESSION['user'] . "'");
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
							$queryStatement = "select distinct(level) from users";
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
		</div>
	</body>
</html>