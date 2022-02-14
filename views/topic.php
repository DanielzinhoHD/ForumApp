<?php
    include_once '../defaults/header.php';
    include_once '../includes/dbh.inc.php';
    include_once '../includes/topic-details.inc.php';
    session_start();
    if(isset($_SESSION['deleted'])){
        if($_SESSION['deleted'] === 1){
            header("location: ../includes/logout.inc.php");
        }
    }
?>
<link rel="stylesheet" href="../styles/topic.css">
<title>Results for <?php getTopicName($topic)?></title>

<body>
    <?php include_once '../defaults/navbar.php'?>

    <div class="offset">
        <div class="container">

            <h2>Posts result for <?php getTopicName($topic)?></h2>

            <div class="results">

                <div class="topic">

                <?php 
                    $result = getPostsFromTopicID($dbh, $topicID);
                    // print_r($result[0]);

                    foreach($result as $key => $value){ ?>
                        <div class="posts item">
                            <div class="item-container">
                                <a href="../views/post.php?id=<?php echo $result[$key]['id']?>">
                                    <div class="subject">
                                        <h3 class="title">
                                            <?php echo ucfirst($result[$key]['name'])?>
                                        </h3>
                                        <div class="text">
                                            <?php echo $result[$key]['text']?>
                                        </div>
                                    </div>
                                    <div class="details">
                                        <p class="comments"><?php getAmoutOfComments($dbh, $result[$key]['id'])?></p>
                                        <p class="date">created at: <?php echo date_format(date_create($result[$key]['creation_date']), 'm/d/y')?></p>
                                    </div>
                                </a>
                            </div>
                            <hr class="horizontal">
                        </div>
                    <?php }
                ?>

                </div>

            </div>

        </div>
    </div>
</body>
</html>
