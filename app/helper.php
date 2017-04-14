<?php

require_once 'config/database.php';

function old($field_name) {
    return isset($_REQUEST[$field_name]) ? $_REQUEST[$field_name] : '';
}

function make_token() {
    $token = sha1(sha1('$$!') . rand(1, 1000) . md5('myblog'));
    $_SESSION['token'] = $token;
    return $token;
}

function email_exist($link, $email) {

    $exist = false;

    $email = mysqli_real_escape_string($link, $email);
    $sql = " SELECT email FROM users WHERE email = '$email'";

    $result = mysqli_query($link, $sql);

    if ($result && mysqli_num_rows($result) > 0) {

        $exist = true;
    }
    return $exist;
}


/*function replaceSlashes(){
    
    $textarea= $post[ 'article' ];
    
str_replace("\n","<br/>", $textarea);

return $textarea;
}*/