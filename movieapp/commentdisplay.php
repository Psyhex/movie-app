<?php
require_once "config.php";

$sql = "SELECT movie_id, content, username ,date_posted from moviecomments ORDER BY moviecomments.date_posted DESC";
$result = $link->query($sql);
if (!$result) {
    trigger_error('Invalid query: ' . $link->error);
}
function current_page_url(){ 
    $page_url   = 'http'; 
    if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on'){ 
        $page_url .= 's'; 
    } 
    return $page_url.'://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']; 
} 
$url_movie_id = parse_url(current_page_url());
parse_str($url_movie_id['query'], $params);

$movie_id_url = $params['id'];
//echo $movie_id_url;
$comment_array = array();

if ($result->num_rows > 0) {
    
    while ($row = $result-> fetch_assoc()){
        if($row["movie_id"] === $movie_id_url){
        array_push($comment_array, "Comment: ".$row["content"]." | Username: ".$row["username"]." | date_posted: ".$row["date_posted"]."|<br>");
 //     <div id="comment_username"> <strong> $row["username"] </strong> </div> <div id="comment_date_posted"> $row["date_posted"] </div> <div id="comment_content"> $row["content"] </div> 
        }
    }
}

$sql_count = "SELECT COUNT(rating_value) FROM movierating WHERE movie_id = ".$movie_id_url."";
$result_count = $link->query($sql_count);
if (!$result_count) {
    trigger_error('Invalid query: ' . $link->error);
}
    $row_count = mysqli_fetch_array($result_count);

$sql_avg = "SELECT AVG(rating_value) FROM movierating WHERE movie_id = ".$movie_id_url."";
$result_avg = $link->query($sql_avg);
if (!$result_avg){
    trigger_error('Invalid query: ' . $link->error);
}
$row_avg = mysqli_fetch_array($result_avg);
$row_avg_2 = $row_avg[0];

$row_avg_rounded = (round($row_avg_2 , 1));


mysqli_close($link);
?>
