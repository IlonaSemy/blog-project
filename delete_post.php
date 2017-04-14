<?php 

require_once 'app/helper.php'; 
session_start(); 

if(! isset($_SESSION['user_id']) ){ 
    
    header('location:signin.php');
} 

$title = "Delete post"; 

if( isset($_POST['submit'])){ 
    
    $post_id= filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING); 
    $post_id = trim ($post_id); 
    
    if(is_numeric($post_id)){ 
        $link = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PWD, MYSQL_DB); 
        $post_id = mysqli_real_escape_string($link, $post_id);
        $uid=$_SESSION['user_id']; 
        $sql="SELECT id FROM posts WHERE id = $post_id AND user_id = $uid"; 
        $result = mysqli_query ($link, $sql); 
        
        if($result && mysqli_num_rows($result)== 1){ 
            
            mysqli_query($link, "DELETE FROM posts WHERE id = $post_id");
            header('location:blog.php');
        }else{ 
            header('location:blog.php');
        }
    }
} 


?> 
<div class="content">
<?php include 'tpl/header.php'; ?>
  <h3>Are you sure you want to delete this post ?</h3>
    <form action="" method="post">
      <input type="submit" name="submit" value="Delete post">
      <input type="button" value="Cancel" onclick="window.location = 'blog.php';">
    </form>
  </div>
<?php include 'tpl/footer.php'; ?>