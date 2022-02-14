<?php 
include_once '../defaults/header.php';
include_once '../includes/dbh.inc.php';

session_start();
if(isset($_SESSION['deleted'])){
    if($_SESSION['deleted'] === 1){
        header("location: ../includes/logout.inc.php");
    }
}

// Getting the search;

$search;
$result;
if(!isset($_GET['search'])){
    header('location: ../index.php');
}else{
    $search = $_GET['search'];
// Getting posts;
    $sql = "SELECT 
                p.id, 
                p.name, 
                p.text, 
                p.creation_date,
                p.deleted,
                COUNT(DISTINCT c.comment) AS NumOfComments
            FROM posts p
            JOIN comments c
                ON c.id_post = p.id
            WHERE 
                p.name LIKE ? OR
                p.text LIKE ? AND
                c.deleted = 0
            GROUP BY
                p.name";

    $stmt = $dbh->prepare($sql);
    $stmt->execute(array("%$search%", "%$search%"));
    $result = $stmt->fetchAll();
    $stmt = null;

// Getting comments;
    $sql = "SELECT 
                p.id, 
                p.name, 
                c.comment,
                c.id AS comment_id,
                c.creation_date,
                c.deleted
            FROM posts p
            JOIN comments c
                ON c.id_post = p.id
            WHERE 
                c.comment LIKE ? AND
                c.deleted = 0
            GROUP BY
                p.name";

    $stmt = $dbh->prepare($sql);
    $stmt->execute(array("%$search%"));
    $comments = $stmt->fetchAll();
    $stmt = null;
}
?>

<link rel="stylesheet" href="../styles/topic.css">
<title>Results for</title>

<body>
    <?php include_once '../defaults/navbar.php';?>

    <div class="offset">
        <div class="container">
            <?php 
                if($result){
                    echo "<h2>Posts result for $search:</h2>";
                }
            ?>

            <div class="results">

                <div class="topic">

                <?php 
                    foreach($result as $key => $value){ ?>
                        <div class="posts item">
                            <div class="item-container">
                                <a href="../views/post.php?id=<?php echo $result[$key]['id']?>">
                                    <div class="subject">
                                        <h3 class="title">
                                            <?php echo ucfirst($result[$key]['name'])?>
                                        </h3>
                                        <div class="text">
                                            <?php echo ucfirst($result[$key]['text'])?>
                                        </div>
                                    </div>
                                    <div class="details">
                                        <p class="comments">
                                            <?php 
                                                if($result[$key]['NumOfComments'] === 1){
                                                    echo $result[$key]['NumOfComments'] . ' comment';
                                                }else{
                                                    echo $result[$key]['NumOfComments'] . ' comments';
                                                }
                                            ?>                                               
                                        </p>
                                        <p class="date">created at: <?php echo date_format(date_create($result[$key]['creation_date']), 'm/d/y')?></p>
                                    </div>
                                </a>
                            </div>
                            <hr class="horizontal">
                        </div>
                    <?php }
                ?>

                </div>
                <?php 
                    if($result){
                        echo "<h2>Comments result for $search:</h2>";
                    }
                ?>
                

                <div class="topic">
                <?php 
                    foreach($comments as $key => $value){ ?>
                    <div class="item user">
                        <div class="item-container">
                            <a href=""><img src="../imgs/face1.png" alt=""></a>
                            <a class="comment-link" href="../views/post.php?id=<?php echo $comments[$key]['id']?>&cId=<?php echo $comments[$key]['comment_id'];?>">
                                <div class="subject">
                                    <h3 class="title">
                                        <?php echo $comments[$key]['name']; ?>
                                    </h3>
                                    <div class="text">
                                        <?php echo $comments[$key]['comment'];?>
                                    </div>
                                </div>
                                <div class="details">
                                    <p class="date">commented at: <?php echo date_format(date_create($comments[$key]['creation_date']), 'm/d/y')?></p>
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