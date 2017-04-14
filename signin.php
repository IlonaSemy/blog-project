<?php
require_once 'app/helper.php';
session_start(); 

if(isset($_SESSION['user_id'])){ 
    header('location:blog.php');
}

$title = 'Sign in page';
$error = "";

if (isset($_POST['submit'])) { 
    
    if( isset ($_POST['token']) && isset($_SESSION['token']) && $_POST['token']==$_SESSION['token']){

    $email=filter_input(INPUT_POST,'email', FILTER_VALIDATE_EMAIL); 
    $email=trim($email);
     $password=filter_input(INPUT_POST,'password', FILTER_SANITIZE_STRING); 
    $password=trim($password);


    if (!$email) {

        $error = 'Email field is required';
    } elseif (!$password) {
        $error = '* Password field is required';
    } else {
        $link = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PWD, MYSQL_DB); 
        $email=  mysqli_real_escape_string($link,$email); 
        $password=  mysqli_real_escape_string($link,$password);
        $sql = "SELECT * FROM users WHERE email='$email' LIMIT 1";
        $result = mysqli_query($link, $sql);


        if ($result && mysqli_num_rows($result) == 1) {

            $user = mysqli_fetch_assoc($result); 
            
            if(password_verify($password,$user['password'])){
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            header('location:blog.php');
        } else {

            $error = '*Wrong email/password combimation';
        } 
        
        } else {

            $error = '*Wrong email/password combimation';
        }
      }  
    } 

    $token=make_token();
} else{
       $token=make_token();
}

?>

<?php include'tpl/header.php'; ?>

<div class="content">  
    <h1 class="SignInpage">Sign in to see and add content</h1> 
    <form action="" method="post" autocomplete="off">  
        <input type="hidden" name="token" value="<?= $token; ?>">
        <label for="email">Email:</label><br> 
        <input type="text" name="email" id="email" value="<?= old('email'); ?>"><br><br> 
        <label for="password">Password:</label><br> 
        <input type="password" name="password" id="password"><br><br> 
        <input type="submit" name="submit" value="Sign in"><br><br> 
        <span class="errorB"><?= $error; ?></span>
    </form>
</div> 

<?php include'tpl/footer.php'; ?>
          