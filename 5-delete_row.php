<?php

$Hostname= "localhost";
$USERNAME="user1";
$PASSWORD= "pass1";
$DATABASE= "startdb";
$tablename="startdb";

$conn   = new mysqli($Hostname, $USERNAME, $PASSWORD,$DATABASE);
$result =select_all($conn,$tablename);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $buttonType = $_POST['buttonType'];

    if ($buttonType == 'create') {
        CreateDatabase($Hostname, $USERNAME, $PASSWORD,$DATABASE);
        CreateTable($Hostname, $USERNAME, $PASSWORD,$DATABASE, $tablename );
    }
    if ($buttonType == 'insert') {
    
        $fields = "txt";
        $values = $_POST["txttxt"];

        Insert($conn,$tablename,$fields,$values);        
    }
    if (isset($_POST['deleteButton'])) {
        $deleteID = $_POST['deleteID'];
        delete($conn,$tablename,$deleteID);

    }    
}
$conn->close();

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

function Insert($conn,$tablename,$fields,$values){
    $insertDataQuery = "INSERT INTO ".$tablename." (".$fields.") VALUES ('$values')";

    if ($conn->query($insertDataQuery) === TRUE) {
        echo "<br>Data inserted successfully";
    } else {
        echo "<br>Error inserting data: " . $conn->error;
    }
}
function select_all($conn,$tablename){
    $selectAllQuery = "SELECT * FROM $tablename";
    $result = $conn->query($selectAllQuery);
    return $result; 
}
function delete($conn,$tablename,$deleteID){
    $deleteRowQuery = "DELETE FROM $tablename WHERE id = '$deleteID'";
    if ($conn->query($deleteRowQuery) === TRUE) {
        echo "<br>Row deleted successfully";
    } else {
        echo "<br>Error deleting row: " . $conn->error;
    }
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

    <form method="post">
        <input type="hidden" name="buttonType" value="create">          
        <button type="submit">Create Table</button>
    </form>
    
    <form method="post">
        <label for="textareaData">Textarea Data:</label>
        <textarea name="txttxt" required></textarea>
        <input type="hidden" name="buttonType" value="insert">
        
        <button type="submit">Submit Textarea</button>
    </form>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Data</th>
        </tr>';
        <?php 
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr><td>" . $row["id"] . "</td>";
                    echo "<td><pre>" . $row["txt"] . "</pre></td>";
                    echo "<td><form method='post'><input type='hidden' name='deleteID' value='" . $row["id"] . "'>";
                    echo "<input type='hidden' name='buttonType' value='delete'>  ";
                    echo "<button type='submit' name='deleteButton'>Delete</button></form></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='2'>No data available</td></tr>";
            }
        ?>
    </table>
</body>
</html>
