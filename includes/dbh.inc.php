<?php
//config files
$dbname = "dbname=loginsystem";
$host = "host=localhost";
$port = "port=5432";
$credentials = "user=postgres password=admin";
$db = pg_connect("$host $port $dbname $credentials");
?>