<?php 
	/* Check if valid!!! */
	$pageName = "Modify User";
	$needDB = true;
	include('inc/header.php');
?>

	<script type="text/javascript" src="admin.js"></script>
	<script type="text/javascript">

		function changeLevel(element) {
			var level = $("[name='" + element + "']")[0].selectedOptions[0].value;

			var url = "admin.ajax.php?function=changeUserLevel&level=" + encodeURIComponent(level) + "&id=" + "<?php echo $_GET['userId']?>";
			$.get(url).done(function(data){
				alert(data);
				parent.$.fancybox.close();
			}).fail(function(data){
				alert("There was an MAJOR ERROR!");
			});

		}

	</script>
</head>
<body>
	<?php
		$queryStatement = "Select level,email from users where id='" . $_GET['userId'] . "';";
		$query = $conn->prepare($queryStatement);
		$query->execute();
		$results = $query->fetch();

		/* Get users level and compares them to see if valid */
		
		switch ($results['level']) {
			case 'teacher':
				$moddedUserLevel = 0;
				break;
			case 'admin':
				$moddedUserLevel = 1;
				break;
			default:
				$moddedUserLevel = 999;
				break;
		}
		
		switch ($_SESSION['level']) {
		case 'teacher':
			$currUserLevel = 0;
			break;
		case 'admin':
			$currUserLevel = 1;
			break;
		case 'superadmin':
			$currUserLevel = 2;
			break;
		default:
			$currUserLevel = -10;
			break;
		}

		if($currUserLevel <= $moddedUserLevel){
			echo "You don't have the permission to modify that user.";
			die();
		}

		//used for security as a check before modifying a user.
		$_SESSION['userModifying'] = $_GET['userId'];
	?>
	<h1><?php echo $results['email']; ?></h1>
	<h2>Change Privelege(<?php echo $results['level']; ?>)</h2>
	<select name="level">
	<?php 
		require('inc/level_dropdown.php');

		$levelsAvaliable = getLevels($_SESSION['level']);

		foreach ($levelsAvaliable as $level) {
			echo "<option value='{$level}'>{$level}</option>";
		}
	?>
	</select>
	<button onclick="changeLevel('level');">Change Level</button>
	<h2>Reset Password</h2>
	<a href="email.php?id=<?php echo $_SESSION['userModifying']; ?>">Reset</a>
	<h5 data-user="<?php echo $_SESSION['userModifying']; ?>" onclick="deleteUser(this);">Delete User</h5>
	<?php include('inc/footer.php'); ?>