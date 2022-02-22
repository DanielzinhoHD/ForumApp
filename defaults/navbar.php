<nav>
<div class="nav-bg"></div>
<div class="nav-container">
    <div class="nav-icon"><a href="../index.php"><i class="far fa-newspaper"></i></a></div>

    <ul>
        <li><a href="../index.php">Home</a></li>
        <li>
            <label for="topics">Topics</label>
            <input type="checkbox" id="topics">
            <div class="topic-list">
                <?php 
                    include_once '../includes/dbh.inc.php';

                    $sql = 'SELECT DISTINCT topics.id, topics.name FROM topics INNER JOIN posts ON topics.id = posts.id_topic WHERE deleted = 0';

                    foreach($dbh->query($sql) as $row){ 
                        echo '<div class="topic-item"><a href="../views/topic.php?id='.$row['id'].'">'.$row["name"].'</a></div>';
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
                        <a href="../views/add-post.php">Create post</a>';
                    if($_SESSION['adm'] === 0){
                        echo '<a href="../views/profile.php">Profile</a>';
                    }
                    if($_SESSION['adm'] === 1){
                        echo '<a href="../views/accounts.php">Account list</a>';
                    }
                    echo '<a href="../includes/logout.inc.php">Log out</a>
                    </div>';
                }else{
                    echo '<a href="../views/enter.php">Enter</a>';
                }
            ?>
            </li>
        <li>
            <form action="../views/results.php" method="GET">
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
<script src="../scripts/navbar.js"></script>