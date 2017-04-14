<?php   

require_once 'app/helper.php';  
session_start(); 

if(! isset($_SESSION['user_id'])){ 
    
    header('location:signin.php');
}

$title='Edit commentt';  
$error=""; 


$comment_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT); 
$comment_id =trim($comment_id ); 

if($comment_id && is_numeric($comment_id )){ 
    
    $uid = $_SESSION['user_id'];  
    $link = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PWD, MYSQL_DB); 
    $comment_id=  mysqli_real_escape_string($link,$comment_id );
    $comsql= "SELECT* FROM comments WHERE id = $comment_id  AND user_id = $uid";
    $comresult=  mysqli_query($link, $comsql); 
    
    if($comresult && mysqli_num_rows($comresult)== 1){ 
        
        $post=mysqli_fetch_assoc($comresult);
        
    }else{ 
        
       header('location: readMore.php');
    }
    
}else { 
    
      header('location:readMore.php');
}



if(isset($_POST['submit'])){ 
    
    $comments = filter_input(INPUT_POST,'comment', FILTER_SANITIZE_STRING); 
    $comments = trim($comments); 
    
    
    if(! $comments){ 
        
        $error = '*Comment field is empty';
    } else{ 
        
        
    $link = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PWD, MYSQL_DB); 
    $comments=mysqli_real_escape_string($link, $comments); 
    $comsql="UPDATE comments SET comment='$comments' WHERE id='$comment_id'"; 
    $comresult = mysqli_query($link,$comsql); 
    
    if($comresult && mysqli_affected_rows($link)>0){ 
        
        $post['id']=$post_id;
        
        header("location: readMore.php?id=$post_id"); 
        
      
    }
}
} 

?> 

<div class="content">  
    
<?php include'tpl/header.php'; ?>

    <form name="comment" method="post"> 
        <label for="comment">Comment here:</label><br><br>
        <textarea rows="15"  cols="15" name="comment" id="comment" value="<?= $post['comment']; ?>"></textarea><br><br> 
        <input type="submit" name="submit" value="Edit comment" onclick="window.location='readMore.php';">  
        <input type="button" value="Cancel" onclick="window.location='readMore.php'"><br><br>
        <span class="errorB"><?= $error; ?></span> 
        
</form>
      <?php include'tpl/footer.php'; ?>
            </div> 