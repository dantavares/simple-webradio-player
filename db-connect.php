<?php
    $db_host = 'localhost';
    $db_name = 'yourdbname';
    $db_user = 'yourdbusername';
    $db_pass = 'yourdbpassword';
    
    $db = mysqli_connect($db_host,$db_user,$db_pass,$db_name);
    if(!$db) { die("Erro ao conectar no banco de dados: " . mysqli_connect_error()); }
