<?php
try{
	$conn = new PDO('mysql:host=sql102.byethost6.com;dbname=b6_13984388_Physics','b6_13984388','CSbths');
}catch(Exception $e){
	echo "DB Error";
	die;
}	 

?>