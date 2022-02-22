<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- importing jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" 
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" 
    crossorigin="anonymous">
    </script> 
    <link rel="stylesheet" href="./styles/defaults.css">
    <link rel="stylesheet" href="./styles/index.css">
    <title>Home</title>
</head>

<?php 
    session_start();
    if(isset($_SESSION['deleted'])){
        if($_SESSION['deleted'] === 1){
            header("location: ./includes/logout.inc.php");
        }
    }
?>

<body>
    <nav>
    <div class="nav-bg"></div>
    <div class="nav-container">
        <div class="nav-icon"><a href="./index.php"><i class="far fa-newspaper"></i></a></div>

        <ul>
            <li><a href="./index.php">Home</a></li>
            <li>
                <label for="topics">Topics</label>
                <input type="checkbox" id="topics">
                <div class="topic-list">
                    <?php 
                        include_once './includes/dbh.inc.php';

                        $sql = 'SELECT DISTINCT topics.id, topics.name FROM topics INNER JOIN posts ON topics.id = posts.id_topic WHERE deleted = 0';

                        foreach($dbh->query($sql) as $row){ 
                            echo '<div class="topic-item"><a href="./views/topic.php?id='.$row['id'].'">'.$row["name"].'</a></div>';
                        };

                    ?>
                </div>
            </li>
            <li>
                <?php 
                    if(isset($_SESSION['id'])){
                        echo '<label for="dropdown">'.ucfirst($_SESSION['name']).'</label>';
                        echo '<input type="checkbox" id="dropdown">';
                        echo '<div class="dropdown">
                            <a href="./views/add-post.php">Create post</a>';
                        if($_SESSION['adm'] === 0){
                            echo '<a href="./views/profile.php">Profile</a>';
                        }
                        if($_SESSION['adm'] === 1){
                            echo '<a href="./views/accounts.php">Account list</a>';
                        }
                        echo '<a href="./includes/logout.inc.php">Log out</a>
                        </div>';
                    }else{
                        echo '<a href="./views/enter.php">Enter</a>';
                    }
                ?>
                </li>
            <li>
                <form action="./views/results.php" method="GET">
                    <input name="search" placeholder="Search..." autocomplete="off">
                    <button type="button"><i class="fa fa-search"></i></button>
                </form>
                <div class="navbar-suggestions"></div>
            </li>
            <li class="bars">
                <i class="fa fa-bars"></i>
            </li>
        </ul>

        
    </div>
    </nav>
    <script src="./scripts/navbar.js"></script>

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