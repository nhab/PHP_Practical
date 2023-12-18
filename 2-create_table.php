<?php

$Hostname= "localhost";
$USERNAME="user1";
$PASSWORD= "pass1";
$DATABASE= "startdb";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dbname="startDB";
    CreateDatabase($Hostname, $USERNAME, $PASSWORD,$dbname);
    $tablename="startdb";
    CreateTable($Hostname, $USERNAME, $PASSWORD,$DATABASE, $tablename );
}

function CreateDatabase($Hostname, $USERNAME, $PASSWORD,$dbname){
    $conn = new mysqli($Hostname, $USERNAME, $PASSWORD);
 
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
 
    $result = $conn->query("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$dbname'");
 
    if ($result->num_rows > 0) {
        echo "Database already exists";
    } else {
        $sql = "CREATE DATABASE $dbname";
        if ($conn->query($sql) === TRUE) {
          echo "Database created successfully";
        } else {
          echo " Error creating database: " . $conn->error;
        }
    }
 
    $conn->close();
 }
 

function CreateTable( $Hostname, $USERNAME, $PASSWORD,$DATABASE,$tablename ) {
    $conn = new mysqli($Hostname, $USERNAME, $PASSWORD,$DATABASE);
    echo "<br>";
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "CREATE TABLE IF NOT EXISTS ". $tablename ." (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        txt VARCHAR(65000) NOT NULL
    )";

    if ($conn->query($sql) === TRUE) {
        echo "Table created successfully";
    } else {
        echo "Error creating table: " . $conn->error;
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Table</title>
</head>
<body>
    <!-- Form to trigger table creation -->
    <form method="post">
        <button type="submit">Create Table</button>
    </form>
</body>
</html>
