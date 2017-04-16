<?php
require_once 'app/helper.php';
session_start();

if ( !isset( $_SESSION[ 'user_id' ] ) && ($_SESSION[ 'user_name' ]) ) {

    header( 'location: signin.php' );
}

$post_id  = filter_input( INPUT_GET, 'id', FILTER_VALIDATE_INT );
$post_id  = trim( $post_id );
$username = $_SESSION[ 'user_name' ];
$comments = [];

if ( $post_id ) {

    $uid     = $_SESSION[ 'user_id' ];
    $link    = mysqli_connect( MYSQL_HOST, MYSQL_USER, MYSQL_PWD, MYSQL_DB );
    $post_id = mysqli_real_escape_string( $link, $post_id );
    $sql     = "SELECT p.*,u.name FROM posts p JOIN users u ON p.id='$post_id' AND p.user_id = u.id";

    $result = mysqli_query( $link, $sql );
    if ( $result && mysqli_num_rows( $result ) == 1 ) {
        $post           = mysqli_fetch_assoc( $result );
        $articleOneLine = htmlentities( $post[ 'article' ] );
        $articleOneLine = explode( "\n", $articleOneLine );
        $article        = '';
        foreach ( $articleOneLine as $line ) {
            $article .= $line . '<br>';
        }
    } else {

        header( 'location: blog.php' );
    }
} else {

    header( 'location: blog.php' );
}


$com_link  = mysqli_connect( MYSQL_HOST, MYSQL_USER, MYSQL_PWD, MYSQL_DB );
$comsql    = "SELECT c.*,u.name FROM posts p JOIN users u ON p.user_id=u.id"
        . " JOIN comments c on p.id=c.post_id ORDER BY p.date DESC";
$comresult = mysqli_query( $com_link, $comsql );

if ( $comresult && mysqli_num_rows( $comresult ) > 0 ) {

    while ( $comrow = mysqli_fetch_assoc( $comresult ) ) {

        $comments[] = $comrow;
    }
}
?>


<div class="content">
    <?php include 'tpl/header.php'; ?>
    <h1></h1>
    <?php if ( $post ): ?>
        <div class="posts-wrapper">

            <div class="post-box-wrapper">
                <p><b>Written by:  </b><?= htmlentities( $post[ 'name' ] ); ?>, On:<?= $post[ 'date' ]; ?>
                <h2><?= htmlentities( $post[ 'title' ] ); ?></h2>
                <p><?= $article; ?></p>  
            </div>
        </div>
    <?php endif; ?>  




    <input type="submit" name="submit" value="Leave a comment" onclick="window.location = 'add_comment.php?id=<?= $post[ 'id' ]; ?>';"> <br><br>

<!--<a href="add_comment.php?id=<?= $post[ 'id' ]; ?>" class="commentslink"> Leave a comment: </a><br><br> -->


    <?php foreach ( $comments as $comm ): ?>  

        <?php if ( $comm[ 'post_id' ] == $post[ 'id' ] ): ?> 
            <div class="sidebar-box-com"> 
                <p><?= htmlentities( $comm[ 'comment' ] ); ?></p>  
                <p><b>Written by: </b><i><?= htmlentities( $post[ 'name' ] ); ?></i>, On: <?= $post[ 'date' ]; ?> 
                    <?php if ( $comm[ 'user_id' ] == $uid ): ?>  
                        <span class="editdelcom"> 
                            <a href="edit_comment.php?id=<?= $comm[ 'id' ]; ?>">Edit comment</a> | 
                            <a href="delete_comment.php?id=<?= $comm[ 'id' ]; ?>">Delete comment</a>

                        </span>



                    <?php endif; ?> 

                <?php endif; ?> 


        </div>  

    <?php endforeach; ?> 


    <?php include 'tpl/footer.php'; ?> 
</div>




