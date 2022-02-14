<?php include_once '../defaults/header.php';

session_start();
if(!isset($_SESSION['id'])){
    header('location: ../views/enter.php');
}
?>

<link rel="stylesheet" href="../styles/add-post.css">
<title>Adding post</title>

<body>
    <?php include_once '../defaults/navbar.php';?>

    <div class="offset">

        <div class="create-post">

            <p id="error"></p>

            <h2>Your post details:</h2>

            <div class="configs">

                <div class="config">
                    <h3>Select a topic or create a new one:</h3>
                    <input type="search" class="input-topic" name="topic" id="" placeholder="Search for topic">    
                    <div class="suggestions"></div>
                </div>

                <div class="config">
                    <h3>Title of your post: <span class="tiny">(You cannot change that later!)</span></h3>
                    <input type="text" class="input-title" name="title" id="" placeholder="Title">    
                </div>
                    
            </div>

            <div class="text">
                <h3>What you wanna talk about:</h3>
                <textarea name="text" id="" cols="30" rows="10" placeholder="Type it here..."></textarea>
            </div>

            <button id="submit" name="submit">Submit post</button>
            
        </div>

    </div>
    
</body>
<script src="../scripts/suggest-topic.js"></script>
<script src="../scripts/submit-post.js"></script>
</html>