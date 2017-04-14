 <?php   

require_once 'app/helper.php';  
session_start(); 

if(! isset($_SESSION['user_id'])){ 
    
    header('location:signin.php');
}

$title='Edit post';  
$error=""; 


$post_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING); 
$post_id=trim($post_id); 

if($post_id && is_numeric($post_id)){ 
    
    $uid = $_SESSION['user_id'];  
    $link = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PWD, MYSQL_DB);  
    $sql= "SELECT* FROM posts WHERE id = $post_id AND user_id = $uid";
    $result=  mysqli_query($link, $sql); 
    
    if($result && mysqli_num_rows($result)== 1){ 
        
        $post=mysqli_fetch_assoc($result);
    }else{ 
        
       header('location: blog.php');
    }
    
}else { 
    
    header('location:blog.php');
}



if(isset($_POST['submit'])){ 
    
    $title=filter_input(INPUT_POST,'title', FILTER_SANITIZE_STRING); 
    $title=trim($title);
     $article=filter_input(INPUT_POST,'article', FILTER_SANITIZE_STRING); 
    $article=trim($article);
    
    if(! $title){ 
        
        $error = '*Title field is required';
    } elseif (! $article) { 
        $error='*Article field is required';
    
}else{ 
    
    $title=mysqli_real_escape_string($link, $title); 
    $article=mysqli_real_escape_string($link, $article);
    $sql="UPDATE posts SET title='$title', article = '$article' WHERE id=$post_id"; 
    $result = mysqli_query($link,$sql); 
    
    if($result && mysqli_affected_rows($link)>0){ 
        
        header('location:blog.php');
    }
}
}
?> 

<div class="content">  
    
<?php include'tpl/header.php'; ?>

             
                <h1>Update post</h1> 
                <form action="" method="post"> 
                <label for="title">Title:</label><br> 
                <input type="text" name="title" id="title" value="<?= $post['title']; ?>"><br><br> 
                <label for="article">Article:</label><br> 
                <textarea rows="10"  cols="50" name="article" id="article"><?= $post['article']; ?></textarea><br><br> 
                <input type="submit" name="submit" value="Update post">  
                <input type="button" value="Cancel" onclick="window.location='blog.php';"><br><br>
                <span class="errorB"><?= $error; ?></span> 
                </form> 
                <?php include'tpl/footer.php'; ?>
            </div> 

