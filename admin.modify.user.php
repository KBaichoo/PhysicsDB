<?php 
	/* Check if valid!!! */
	$pageName = "Modify User";
	$needDB = true;
	include('inc/header.php');

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
?>
<h1><?php echo $results['email']; ?></h1>
<h2>Change Privelege</h2>
drop down
<h2>Reset Password</h2>
<a href="">Reset</a>
<h5>Delete User</h5>