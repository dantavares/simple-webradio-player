<?php
   include('db-connect.php'); 
   $id = $_GET['id'];
   header("Content-Type: image/jpeg");
   $query = mysqli_query($db, "select logo1 from estacoes where id=$id");
   $img_val = mysqli_fetch_array($query);
   echo $img_val['logo1'];
?>