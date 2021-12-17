<?php 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "newjsonapi";
$dbtable = "json_data";

// Retrieving data from api
$api = "https://jsonplaceholder.typicode.com/todos/";
$data = file_get_contents($api);
$result = json_decode($data, true);


// Creating connection to mysql
$conn = new mysqli($servername, $username, $password);

// Checking connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Creating new database 
$sql = "CREATE DATABASE $dbname";
if ($conn->query($sql) === TRUE) {
  echo "Database created successfully";
} else {
  echo "Error creating database: " . $conn->error;
}

mysqli_select_db($conn, $dbname) or die(mysqli_error($conn));


// Creating new table and storing .json data
foreach($result as $item) {
    $table = "INSERT INTO $dbtable(userId, id, title, completed)
              VALUES ('". $item['userId'] ."', 
                      '". $item['id'] ."', 
                      '". $item['title'] ."', 
                      '". $item['completed'] ."')";


    mysqli_query($conn, $table);
}


// Closing connection
mysqli_close($conn);
?>


