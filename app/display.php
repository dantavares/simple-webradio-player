<?php
	error_reporting(0);
	include('db-connect.php'); 
	$pid = $_GET['id'];
	header("Content-Type: image/jpeg");
   		
	$stmt = $db->prepare("SELECT logo1 FROM estacoes WHERE id = :id");
	$stmt->bindValue(':id', $pid, SQLITE3_INTEGER);
	$result = $stmt->execute();
	$row = $result->fetchArray(SQLITE3_ASSOC);
	echo $row['logo1'];
?>