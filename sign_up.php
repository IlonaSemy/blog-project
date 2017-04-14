<?php

require_once 'app/helper.php';
session_start();

if (isset($_SESSION['user_id'])) {

  header('location: blog.php');
}

$title = 'Sign up page';
$error[0] = $error[1] = $error[2] = $error[3] = '';

if (isset($_POST['submit'])) {

  if (isset($_POST['token']) && isset($_SESSION['token']) && $_POST['token'] == $_SESSION['token']) {
    
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $name = trim($name);
    
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $email = trim($email);
    
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    $password = trim($password);
    
    $confpassword = filter_input(INPUT_POST, 'confirmPassword', FILTER_SANITIZE_STRING);
    $confpassword = trim($confpassword);
    $valid = true;
    
    $link = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PWD, MYSQL_DB);
    
    if( ! $name || strlen($name) < 2 || strlen($name) > 70){
      
      $error[0] = ' * Name field is required, min:2 max:70';
      $valid = false;
      
    }
    
    if( ! $email  ){
      
      $error[1] = ' * A valid email is required';
      $valid = false;
      
    } elseif( email_exist($link, $email) ){
      
      $error[1] = ' * The email is taken';
      $valid = false;
      
    }
    
    if( ! $password || strlen($password) < 6 || strlen($password) > 10 ){
      
      $error[2] = ' * Password field is required, min:6 max:10';
      $valid = false;
      
    } elseif( $password != $confpassword ){
      
      $error[3] = ' * Password mismatch';
      $valid = false;
      
    }
    
    if( $valid ){
      
      $name = mysqli_real_escape_string($link, $name);
      $email = mysqli_real_escape_string($link, $email);
      $password = mysqli_real_escape_string($link, $password);
      $password = password_hash($password, PASSWORD_BCRYPT);
      $sql = "INSERT INTO users VALUES('','$name','$email','$password')";
      $result = mysqli_query($link, $sql);
      
      if( $result && mysqli_affected_rows($link) == 1 ){
        
          $_SESSION['user_id'] = mysqli_insert_id($link);
          $_SESSION['user_name'] = $name;
          header('location: blog.php?sm=' . $name . ' your account created!');
        
      }
      
      
    }

  }

  $token = make_token();
  
} else {

  $token = make_token();
}
?>

<?php include 'tpl/header.php'; ?>
<div class="contentSU">
  <h1>Sign up in order to see content </h1>
  <form action="" method="post">
    <input type="hidden" name="token" value="<?= $token; ?>">
    <label for="name">Name:</label><br>
    <input type="text" name="name" id="name" value="<?= old('name'); ?>">
    <span class="errorSU"><?= $error[0]; ?></span><br><br>
    <label for="email">Email:</label><br>
    <input type="text" name="email" id="email" value="<?= old('email'); ?>">
    <span class="errorSU"><?= $error[1]; ?></span><br><br>
    <label for="password">Password:</label><br>
    <input type="password" name="password" id="password">
    <span class="errorSU"><?= $error[2]; ?></span><br><br>
    <label for="confirmPassword">Confirm password:</label><br>
    <input type="password" name="confirmPassword" id="confirmPassword">
    <span class="errorSU"><?= $error[3]; ?></span><br><br>
    <input type="submit" name="submit" value="Sign up"><br><br>
  </form>
</div>
<?php include 'tpl/footer.php'; ?>