<?php

// //Get Heroku ClearDB connection information
// $cleardb_url = parse_url(getenv("CLEARDB_DATABASE_URL"));
// $cleardb_server = $cleardb_url["host"];
// $cleardb_username = $cleardb_url["user"];
// $cleardb_password = $cleardb_url["pass"];
// $cleardb_db = substr($cleardb_url["path"],1);
// $active_group = 'default';
// $query_builder = TRUE;

// // Connect to DB
// $conn = mysqli_connect($cleardb_server, $cleardb_username, $cleardb_password, $cleardb_db);

// if(!$conn){
//     die("Connection failed: " . mysqli_connect_error());
// }

// Connecting via PDO;
try{
    $dbname = 'forum_website';
    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpw = '';

    $options = [
        PDO::ATTR_EMULATE_PREPARES   => false, // turn off emulation mode for "real" prepared statements
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, //turn on errors in the form of exceptions
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //make the default fetch be an associative array
      ];

    return $dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpw, $options);
    
}catch(PDOException $e){
    print "Error!: ".$e->getMessage() . "<br/>";
    die();
}