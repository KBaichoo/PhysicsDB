<?php
try{

	$conn = new PDO('mysql:host=localhost;dbname=physics_db','root','');
}catch(Exception $e){
	echo "DB Error";
	die;
}	 

?>