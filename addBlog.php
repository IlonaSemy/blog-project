<?php   

require_once 'app/helper.php';  
session_start(); 

if(! isset($_SESSION['user_id'])){ 
    
    header('location:signin.php');
}

$title='Add new post';  
$error="";

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
    
    $link=mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PWD, MYSQL_DB); 
    $uid = $_SESSION['user_id']; 
    $sql="INSERT INTO posts VALUES('',$uid,'$title','$article', NOW())"; 
    $result = mysqli_query($link,$sql); 
    
    if($result && mysqli_affected_rows($link)>0){ 
        
        header('location:blog.php');
    }
}
}
?> 

<div class="content">  
    
<?php include'tpl/header.php'; ?>

             
                <h1>Add new post</h1> 
                <form action="" method="post"> 
                <label for="title">Title:</label><br> 
                <input type="text" name="title" id="title" value="<?= old('title'); ?>"<br><br> 
                <label for="article">Article:</label><br> 
                <textarea rows="10"  cols="50" name="article" id="article"><?= old('article');?></textarea><br><br> 
                <input type="submit" name="submit" value="Add post">  
                <input type="button" value="Cancel" onclick="window.location='blog.php';"><br><br>
                <span class="errorB"><?= $error; ?></span> 
                </form> 
                <?php include'tpl/footer.php'; ?>
            </div> 

