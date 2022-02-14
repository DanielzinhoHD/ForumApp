<?php

if(isset($_POST["submit"])){
    
    $email = $_POST['email'];
    $password = $_POST['pwd'];

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    if(emptyInputsLogin($email, $password) !== false){
        echo 'You need to fill all the inputs!';
        exit();
    }

    if(invalidEmail($email) !== false){
        echo 'You need to insert a valid email!';
        exit();
    }

    if(existingEmail($dbh, $email) == false){
        echo 'This email doesn\'t exist!';
        exit();
    }

    if(loginUser($dbh, $email, $password) !== false){
        exit();
    }else{
        echo 'This account was banned!';
        exit();
    }

}else{
    echo 'There was an error!';
    exit();
}