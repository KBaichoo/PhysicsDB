<?php
try{
	$conn = new PDO('mysql:host=localhost;dbname=physics','root','');
}catch(Exception $e){
	echo "DB Error";
	die;
}	 

?>