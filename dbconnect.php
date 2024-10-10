<?php

try {
    //code...
    $host = "localhost";
    $dbname = "myblog";
    $dbuser = "root";
    $dbpassword = "";

    //Data source name
    $dsn = "mysql:host=$host;dbname=$dbname";
    $conn = new PDO($dsn,$dbuser,$dbpassword);

    //or 

    // $conn = new PDO("mysql:host=localhost;dbname=myblog","root","")

    $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    // echo "connection success";

} catch (PDOException $e) {
    die("Connection fail:".$e->getMessage());
}

?>