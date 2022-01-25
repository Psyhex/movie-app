<?php 
require_once "config.php";
session_start();

$username = $_SESSION["username"];
$sql_line ="SELECT * FROM `favmovie` WHERE username="."\"$username\";";

$result = $link->query($sql_line);
$to_encode = array();
while($row = mysqli_fetch_array($result)) {
  $to_encode[] = $row;
}

if (json_encode($to_encode) === '[]' ){
    echo "";
}else {
 echo json_encode($to_encode);
 
}

