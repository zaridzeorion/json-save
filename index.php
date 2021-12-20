<?php
// Retrieving api data
$api = "https://gorest.co.in/public/v1/posts";
$data = file_get_contents($api);
$result = json_decode($data, true);

$host = 'localhost';
$root = 'root';
$pass = '';
$dbname = 'mynewdatabase';
$dbtable = 'posts';

// Connection:
$conn = new PDO("mysql:host=localhost;", $root, $pass);
// set the PDO error mode to exception
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


// First: Create new database
try
{
    $sql = "CREATE DATABASE $dbname";
    $conn->exec($sql);

    echo "Database $dbname created successfully";
}
catch(PDOException $e)
{
    die("DB ERROR: " . $e->getMessage());
}


// Second: Create new table inside newly created database
try
{

    $conn->exec('USE ' . $dbname);

    $sql = "CREATE TABLE $dbtable (
      id INT PRIMARY KEY,
      user_id INT,
      title VARCHAR(255),
      body VARCHAR(255)
    )";

    $conn->exec($sql);

    echo "Table $dbtable created successfully ";

}
catch(PDOException $e)
{
    echo $sql . "<br>" . $e->getMessage();
}


// Third: Insert data as rows into table columns
foreach ($result['data'] as $row)
{
    $id = $row['id'];
    $user_id = $row['user_id'];
    $title = $row['title'];
    $body = $row['body'];

    try
    {
        $conn->exec("INSERT INTO $dbtable (id, user_id, title, body) 
                     VALUES ('$id', '$user_id', '$title', '$body')");

        echo "Info inside table - $dbtable inserted successfully ";

    }
    catch(PDOException $e)
    {
        if ($e->errorInfo[1] == 1062)
        {
            // Duplicate entry occured
            
        }
        else
        {
            // An error other than duplicate entry occurred
            
        }
    }
}

$conn = null; // Close connection

?>
