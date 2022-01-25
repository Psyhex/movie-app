<?php

// Include config file
require_once "config.php";

function current_page_url(){ 
    $page_url   = 'http'; 
    if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on'){ 
        $page_url .= 's'; 
    } 
    return $page_url.'://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']; 
} 
 
/* (Assuming session already started) */ 
if(isset($_SESSION['referrer'])){ 
    // Get existing referrer 
    $referrer   = $_SESSION['referrer']; 
 
} elseif(isset($_SERVER['HTTP_REFERER'])){ 
    // Use given referrer 
    $referrer   = $_SERVER['HTTP_REFERER']; 
 
} else { 
    // No referrer 
} 
 
// Save current page as next page's referrer 
$_SESSION['referrer']   = current_page_url(); 
if(isset($referrer)){ 
    echo $referrer;
     
} else { 
    echo 'Error geting URL'; 
} 
$url_components = parse_url($referrer);

parse_str($url_components['query'], $params);
echo "<br>";
echo $params['id'];
$movieid = $params['id'];
session_start();
$username = $_SESSION["username"];
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header('Location: '.$referrer.'');
    
    
  }else {
    echo $username;
  }

$movie_comment = mysqli_real_escape_string($link, $_REQUEST['movie_comment']);
if ($movie_comment === null ){
    echo "error";
}
$movie_comment = strip_tags($movie_comment);
$sql = "INSERT INTO moviecomments (content, username, movie_id)
VALUES ('$movie_comment','$username','$movieid')";

if(mysqli_query($link, $sql)){
     echo "Records added successfully.";

} else{
     echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}
header('Location: '.$referrer.'');
mysqli_close($link);
?>