<?php 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "newjsonapi";

$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieving data from api
$api = "https://jsonplaceholder.typicode.com/todos/";
$data = file_get_contents($api);
$result = json_decode($data, true);


// Creating new database
$sql = "CREATE DATABASE $dbname";
if ($conn->query($sql) === TRUE) {
  echo "Database created successfully";
} else {
  echo "Error creating database: " . $conn->error;
}


mysqli_select_db($conn, $dbname) or die(mysqli_error($conn));


foreach($result as $row) {
    print_r($row);
    $table = "INSERT INTO 'json_dataa' (userId, id, title, completed) VALUES ('". $row['userId'] ."', '". $row['id'] ."', '". $row['title'] ."', '". $row['completed'] ."')";

    mysqli_query($conn, $table);
}



mysqli_close($conn);
?>


