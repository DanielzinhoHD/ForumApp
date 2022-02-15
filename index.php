<?php 
    include_once './defaults/header.php';
    try{
    include_once './defaults/navbar.php';
    }catch(Exception $e){
        print_r($e);
    }
?>
<title>Home</title>

<?php 
    session_start();
    if(isset($_SESSION['deleted'])){
        if($_SESSION['deleted'] === 1){
            header("location: ../includes/logout.inc.php");
        }
    }
?>

<body>

    <div class="offset">
    
        <div class="posts">
            <div id="games">

                <?php 
            // Selecting topics with most recent 5 posts;
                $sql = "SELECT 
                            DISTINCT p.id_topic,
                            t.name
                        FROM posts p
                        LEFT JOIN topics t
                            ON t.id = p.id_topic
                        WHERE 
                            p.deleted = 0
                        GROUP BY
                            p.creation_date DESC
                        LIMIT 5;";

                $stmt = $dbh->prepare($sql);
                $stmt->execute();
                $result = $stmt->fetchAll();
                $stmt = null;
                
            // Returning the most recent 5 posts of each topic;
                foreach($result as $key => $val){
                   $sql = "SELECT 
                                p.id, 
                                p.name, 
                                p.text, 
                                p.creation_date,
                                a.img_dir,
                                p.deleted,
                                COUNT(DISTINCT c.comment) AS NumOfComments
                            FROM posts p
                            JOIN comments c
                                ON c.id_post = p.id
                            JOIN accounts a
                                ON a.id = p.id_account_owner
                            WHERE
                                p.id_topic = ? AND
                                p.deleted = 0
                            GROUP BY
                                p.name;";

                    $stmt = $dbh->prepare($sql);
                    $stmt->execute(array($val['id_topic']));
                    $posts = $stmt->fetchAll();
                    $stmt = null;    ?>

                    <h1 class="topic-title"><?= $result[$key]['name']?>:</h1> 

                    <div id="topic-news" class="topic">
                    
                    <?php 
                    
                    foreach($posts as $postK => $postV){ ?>
                        <div class="item">
                            <a class="item-container" href="./views/post.php?id=<?= $posts[$postK]['id']?>">
                                <img src="imgs/<?= $posts[$postK]['img_dir']?>" alt="">
                                <div class="subject">
                                    <h3 class="title">
                                        <?= ucfirst($posts[$postK]['name'])?>
                                    </h3>
                                    <div class="text">
                                    <?= ucfirst($posts[$postK]['text'])?>
                                    </div>
                                </div>
                                <div class="details">
                                    <p class="comments">
                                    <?php 
                                        if($posts[$postK]['NumOfComments'] === 1){
                                            echo $posts[$postK]['NumOfComments'] . ' comment';
                                        }else{
                                            echo $posts[$postK]['NumOfComments'] . ' comments';
                                        }
                                    ?>
                                    </p>
                                    <p class="date"><?= ucfirst($posts[$postK]['creation_date'])?></p>
                                </div>
                            </a>
                            <hr class="horizontal">
                        </div>
                    <?php }
                    
                    ?>
                    </div>
                <?php }
                ?>

            </div>
        </div>
    </div>

</body>

</html>