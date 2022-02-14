<?php

if(isset($_POST["submit"])){
    
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["pwd"];
    $password2 = $_POST["pwd2"];
    $vkey = md5(time().$name);

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';
    // require_once 'sendemail.inc.php';

    if(emptyInputsRegister($name, $email, $password, $password2) !== false){
        echo "You need to fill all the inputs!";
        exit();
    }

    if(toShortName($name) !== false){
        echo "This name is to short!";
        exit();
    }

    if(pwdMatch($password, $password2) !== false){
        echo "Passwords are different!";
        exit();
    }

    if(invalidEmail($email) !== false){
        echo "Invalid email!";
        exit();
    }

    if(existingEmail($dbh, $email) !== false){
        echo "Email is alredy being used!";
        exit();
    }

    if(createUser($dbh, $name, $email, $password, $vkey) !== false){
    // Send email;
        // $to = $email;
        // $subject = "Random Recipes - Email Verification";
        // $content = "<p>Click the link below to verify your email:</p>
        // <a href='https://recipeapp-exercise.herokuapp.com/includes/verify.inc.php?vkey=$vkey'>
        //     Register account
        // </a>";

        // SendEmail::sendMail($to, $subject, $content);
        exit();
    }else{
        exit();
    }
}else{
    echo "There was an error!";
    exit();
}