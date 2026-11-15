<?php

$host = "localhost";
$username = "root";
$password = "";
$database = "starbuck";

$conn = new PDO(
    'mysql:host=' . $host . ';dbname=' . $database,
    $username,
    $password
);
