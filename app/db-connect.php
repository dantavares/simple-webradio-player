<?php

$db = new SQLite3('radio.db');

if(!$db) {
    die("Erro ao conectar no banco de dados.");
}
?>