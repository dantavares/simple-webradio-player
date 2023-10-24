<!DOCTYPE html>
<html>
<head><meta name="viewport" content="width=device-width, initial-scale=1"/></head>
<body>

<?php
	include('db-connect.php');
	$max_size = 512; //KB
	$allowTypes = array('jpg','png','jpeg','gif','JPG','PNG','JPEG','GIF');
	$fileName = basename($_FILES["image"]["name"]); 
    $fileType = pathinfo($fileName, PATHINFO_EXTENSION);	
	
	$pid = $_POST['id'];
	$gid = $_GET['id'];
	$err = $_GET['err'];
			
	if(isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
		if($_FILES['image']['size'] > $max_size * 1024 || !(in_array($fileType, $allowTypes)) ){
			header("Location: upload.php?err=1&id=$pid");
		}else{
			$data = file_get_contents($_FILES['image']['tmp_name']);
			$stmt = mysqli_prepare($db, "update estacoes set logo1=? where id=$pid");
			mysqli_stmt_bind_param($stmt, "s", $data);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
			header("Location: radio-config.php?vsrad=$pid");
		}
	}else{
		echo '<form method="post" action="upload.php" enctype="multipart/form-data">';
		echo "Imagem Atual:<BR>";
		echo "<img src='display.php?id=$gid' width='100' height='100' /><BR><BR>";
		echo '<input type="file" name="image" accept="image/,.jpg,.png,.jpeg,.gif" /><BR><BR>';
		echo "<input type='hidden' name='id' value='$gid' />";
		echo '<input type="submit" name="submit" value="Atualizar Imagem" /><BR><BR>';
		if ($err == "1") {
			echo "<p style='color:red;'>Erro! Arquivo muito grande! Tamanho máximo de 512Kb ou o arquivo não é uma imagem aceita</p>";
		}
		echo '</form>';	
   }
?>