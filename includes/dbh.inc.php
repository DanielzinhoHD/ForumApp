<?php
// try{
// //Get Heroku ClearDB connection information
// $cleardb_url = parse_url(getenv("CLEARDB_DATABASE_URL"));
// $cleardb_server = $cleardb_url["host"];
// $cleardb_username = $cleardb_url["user"];
// $cleardb_password = $cleardb_url["pass"];
// $cleardb_db = substr($cleardb_url["path"],1);
// $active_group = 'default';
// $query_builder = TRUE;

// $options = [
//     PDO::ATTR_EMULATE_PREPARES   => false, // turn off emulation mode for "real" prepared statements
//     PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, //turn on errors in the form of exceptions
//     PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //make the default fetch be an associative array
// ];

// // Connect to DB
// $dbh = new PDO("mysql:host=$cleardb_server; dbname=$cleardb_db", $cleardb_username, $cleardb_password, $options);

// }catch(PDOException $e){
//     print "Error!: ".$e->getMessage() . "<br/>";
//     die();
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