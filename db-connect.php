<?php
    $db_host = 'your db host';
    $db_name = 'your db name';
    $db_user = 'your db username';
    $db_pass = 'your db password';
    
    $db = mysqli_connect($db_host,$db_user,$db_pass,$db_name);
    if(!$db) { die("Erro ao conectar no banco de dados: " . mysqli_connect_error()); }
