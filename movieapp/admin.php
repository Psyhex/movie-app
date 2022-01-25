<?php
require_once "config.php";
// Initialize the session

session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: adminlog.php");
    exit;
}
if($_SESSION["username"] === 'admin'){
    
}else {
    header("location: index.php");
}
$sql_count_users = "SELECT COUNT(id) FROM users;";
$result_count_users = $link->query($sql_count_users);
if (!$result_count_users) {
    trigger_error('Invalid query: ' . $link->error);
}
    $row_count_users = mysqli_fetch_array($result_count_users);
//SELECT COUNT(id) FROM users; 
//echo $row_count_users[0];
$sql_count_comments = "SELECT COUNT(comment_id) FROM moviecomments;";
$result_count_comments = $link->query($sql_count_comments);
if (!$result_count_comments){
    trigger_error('Invalid query: ' . $link->error);
}
    $row_count_comments = mysqli_fetch_array($result_count_comments);

$sql_count_total_ratings = "SELECT COUNT(id) FROM movierating;";
$result_count_total_ratings = $link->query($sql_count_total_ratings);
if (!$result_count_total_ratings){
    trigger_error('Invalid query: ' . $link->error);
}
    $row_count_total_ratings = mysqli_fetch_array($result_count_total_ratings);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN PANEL</title>
    <div id="total_users">Total users: <?php echo $row_count_users[0]; ?> </div>
    <div id="total_comments">Total comments: <?php echo $row_count_comments[0]; ?></div>
    <div id="total_ratings"> Total ratings: <?php echo $row_count_total_ratings[0]; ?></div>
</head>
<body>
    
</body>
</html>