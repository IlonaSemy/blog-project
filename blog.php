<?php 

require_once 'app/helper.php';
session_start();

if( ! isset($_SESSION['user_id']) ){
  
  header('location: signin.php');
  
}

$title = 'Blog page';
$posts = []; 

$link = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PWD, MYSQL_DB);
$sql = "SELECT p.*,u.name FROM posts p "
        . "JOIN users u ON p.user_id = u.id "
        . "ORDER BY p.date DESC";

$result = mysqli_query($link, $sql);

if( $result && mysqli_num_rows($result) > 0 ){
  
  while($row = mysqli_fetch_assoc($result)){
    
    $posts[] = $row;
    
  }
  
} 

$uid=$_SESSION['user_id'];

?>
<div class="content"> 
    
<?php include'tpl/header.php'; ?>

             
               <h1>My little paper plane </h1> 
               <p> 
                   <input type="button" value="Add post" onclick="window,location='addBlog.php';">
               </p>  
               <?php if($posts): ?>  
               
               <?php foreach($posts as $post): ?>
               <div class="sidebar-box">
                   <p><b>Written by:  </b><?= htmlentities($post['name']); ?>, On:<?= $post['date']; ?>
                       <?php if($post['user_id']== $uid): ?>
                       <span class="editdel"> 
                       <a href="edit_post.php?id=<?= $post['id']; ?>">Edit</a>  
                       <a href="delete_post.php?id=<?= $post['id']; ?>">Delete</a> 
                       <span> 
                       <?php endif; ?>
                       </p>
                <h2><?= htmlentities($post['title']); ?></h2>  
                <p><?= htmlentities($post['article']); ?></p> 
                <p class="read-more"><a href="readMore.php?id= <?= $post['id']; ?>" class="button">Read more...</a></p>
                </div>    
             
                <?php endforeach; ?> 
                <?php endif; ?>  
               <?php include'tpl/footer.php'; ?>
            </div>
