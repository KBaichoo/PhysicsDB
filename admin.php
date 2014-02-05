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
				width: 450px;
				height: 200px;
				background-color: blue;
			}
		</style>
		<script type="text/javascript" src="admin.js"></script>
		
	</head>
	<body>
		<?php include('inc/nav_bar.php'); ?>
		<div id="outerContainer" class="container">

			<?php if(count($_GET) == 0){ ?>
			<div id="modifyMyAccount" class="panel panel-primary">
				<h3 class="panel-heading">Change My Password</h3>
				<div class="panel-body">
					<div class="result"></div>
					To change your password <?php echo $_SESSION['user'] ?> simply type it here 
					<input type="password" placeholder="password">
					<input type="password" placeholder="password">
					<button onclick="updatePassword();">Change my password!</button>
				</div>
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