<?php 
	require_once ("mensajes.php");
	$messageId = $_GET['id'];
	$mensaje = new Mensaje();
	$mensaje->get($messageId);
	
	
?>

 