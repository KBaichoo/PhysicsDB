<?php
	$pageName = "Admin Panel";
	$needDB = true;
	include('inc/header.php');
	//REDIRECTS Teachers
	if(count($_GET) > 0 && $_SESSION['level'] == 'teacher'){
		header("Location:admin.php");
	}
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

			<?php if(count($_GET) == 0){ ?>
			<div id="modifyMyAccount">
				<div class="result"></div>
				To change your password <?php echo $_SESSION['user'] ?> simply type it here 
				<input type="password">
				<input type="password">
				<button onclick="updatePassword();">Change my password!</button>
			</div>
			<?php } ?>

			<?php if(isset($_GET['manage']) && $_GET['manage'] == 'items'){ 
				include('admin.manage.item.php');
			 } 
			 ?>
			<?php if(isset($_GET['manage']) && $_GET['manage'] == 'accounts'){
				include('admin.manage.accounts.php');
			} ?>

		</div>
	<?php include('inc/footer.php'); ?>