<?php   

require_once 'app/helper.php';  
session_start(); 

if(! isset($_SESSION['user_id'])){ 
    
    header('location:signin.php');
}

$title='Add new comment';  
$error="";

if(isset($_POST['submit'])){ 
    
    
    $comments = filter_input(INPUT_POST,'comment', FILTER_SANITIZE_STRING); 
    $comments = trim($comments);
    $post_id  = filter_input( INPUT_GET, 'id', FILTER_VALIDATE_INT );
    $post_id  = trim( $post_id );
 
   if (! $comments) { 
        $error='*Comment field is required';
    
}else{ 
    
    $com_link = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PWD, MYSQL_DB); 
    $uid = $_SESSION['user_id']; 
    $post_id = mysqli_real_escape_string( $com_link, $post_id ); 
    $comments = mysqli_real_escape_string( $com_link, $comments );
    $comsql="INSERT INTO comments VALUES('',$post_id,$uid,'$comments', NOW())"; 
    $comresult = mysqli_query($com_link,$comsql); 
    
    if($comresult && mysqli_affected_rows($com_link)>0){ 
        
        header('location:readMore.php');
    }
}
}
?> 

<div class="content">  
    
<?php include'tpl/header.php'; ?>

    <form name="comment" method="post"> 
        <label for="comment">Comment here:</label><br><br>
        <textarea rows="15"  cols="15" name="comment" id="comment"></textarea><br><br> 
        <input type="submit" name="submit" value="Add comment" onclick="window.location='readMore.php?id= <?= $post['id']; ?>';">  
        <input type="button" value="Cancel" onclick="window.location='readMore.php'"><br><br>
        <span class="errorB"><?= $error; ?></span> 
        
</form>
      <?php include'tpl/footer.php'; ?>
            </div> 