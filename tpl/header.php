<html>
    <head>
        <meta charset="UTF-8">
        <title> Fly me a paper plane blog <?= $title ?></title> 
        <link href="css/style2.css" rel="stylesheet" type="text/css"/> 
        
    </head>
    <body> 
        <div class="page-wrapper"> 
            <div class="header"> 
                <ul> 
                    <li><a href="index.php">Fly me a paper plane</a></li> 
                    <li><a href="blog.php">Blog</a></li>   
                    <li><a href="travelHacks.php">Travel Hacks</a></li> 
                    <?php if(! isset($_SESSION['user_id'])): ?> 
                    <li><a href="signin.php">Signin</a></li>  
                    <li><a href="sign_up.php">Signup</a></li>   
                    <?php else: ?> 
                    <li><a href="logout.php">Logout</a></li><br>
                    <li>Hello,<?= htmlentities($_SESSION['user_name']); ?></li><br><br>
                    <?php endif; ?>
                    
                </ul> 
            </div> 