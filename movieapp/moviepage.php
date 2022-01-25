<?php
// Initialize the session
session_start();
require_once "commentdisplay.php";
require_once "config.php";
//echo count($comment_array);
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
  
  $checkLoginTopRight = " Login";
  $userSeperate = "";
  $userNameDisplayTopRight = "";
  $disabled = "disabled";
  $disabledText = "You need to be logged in to wright a comment";
  $disabledTextR = "You need to be logged in to rate a movie";
  $favmovie_disabled ="disabled";
  $watchlist_disabled = "disabled";
}else {
  $checkLoginTopRight = str_replace(" Login","Logout"," Login");
  $userSeperate = "Welcome, ";
  $userNameDisplayTopRight = htmlspecialchars($_SESSION["username"]);
  $disabled = "";
  $disabledText = "";
  $disabledTextR = "";
  $favmovie_disabled ="";
  $watchlist_disabled = "";
}

if(isset($_SESSION["username"])){
  $sql_favmovie_count = "SELECT COUNT(id) FROM favmovie WHERE movie_id = ".$movie_id_url." AND username='".$_SESSION["username"]."'";
 

$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
$result_favmovie = mysqli_query($link, $sql_favmovie_count);
$result_favmovie2 = $result_favmovie->fetch_assoc();

if ($result_favmovie2['COUNT(id)'] == 0){
 $favmovie_disabled = " ";
}else {
$favmovie_disabled = "disabled";
}
}
if(isset($_SESSION["username"])){
  $sql_watchlistmovie_count = "SELECT COUNT(id) FROM watchlistmovie WHERE movie_id = ".$movie_id_url." AND username='".$_SESSION["username"]."'";
 

$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
$result_watchlistmovie = mysqli_query($link, $sql_watchlistmovie_count);
$result_watchlistmovie2 = $result_watchlistmovie->fetch_assoc();

if ($result_watchlistmovie2['COUNT(id)'] == 0){
  $watchlist_disabled = "";
}else {
  $watchlist_disabled = "disabled";
}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Kąžiūrėti.lt</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <script src="assets/apiTransaction.js"></script>
  <script src="assets/app.js"></script>
  <style>
    /* Remove the navbar's default margin-bottom and rounded borders */ 
    .navbar {
      margin-bottom: 0;
      border-radius: 0;
    }
    
    /* Set height of the grid so .sidenav can be 100% (adjust as needed) */
    .row.content {height: 450px}
    
    /* Set gray background color and 100% height */
    .sidenav {
      padding-top: 20px;
      height: 100%;
    }
    
    /* Set black background color, white text and some padding */
    footer {
      background-color: #555;
      color: white;
      padding: 15px;
    }
    
    /* On small screens, set height to 'auto' for sidenav and grid */
    @media screen and (max-width: 767px) {
      .sidenav {
        height: auto;
        padding: 15px;
      }
      .row.content {height:auto;} 
    }
    #inputValue{
    width: 100%;
    max-width: 550px;
    padding: .375rem .75rem;
    font-size: 1rem;
    line-height: 1.5;
    border-radius: .25rem;
    outline: none;
    color: grey;
    background-color:white;
    border-radius: .25rem;
    margin-right: 100px;
   
}
#search {
    color: white;
    background-color: rgb(51, 51, 51);
    outline: none;
    min-height: 38px;
    font-weight: 400;
    text-align: center;
    cursor: pointer;
    padding: .375rem .75rem;
    font-size: 15px;
    line-height: 1.5;
    border-radius: .25rem;
    width: 100%;
}
.moviePoster {
  margin-top: 10px;
  max-height: 800px;
  max-width: 540px;
  
} 
section {
    display: flex;
    width: 100%;
    overflow-x: auto;
}
section img {
    width: 150px;
    transition: 250ms all;
    border-radius: 5%;
    position:relative;   
   
}
.movie-title {
  
  font-size: 15px;
  display: block;
}
.release_date{

font-size: 10px;
display: block;
}
.movieVoteavg{

font-size: 10px;
display: block;
}
.imgclass:hover {
    cursor: pointer;
    opacity: 50%;
}
.green {
  
  color: #008000;
}
.red {
  
  color: #ff1414;
}
.orange{
  
 color: #FFA500;
}
textarea[name='movie_comment'] { 
   resize: none; 
}
.blue{
  color: blue;
} 
#warning_comment {
  display: none;
}
#comment_single {
  background-color: lightgray;
  border-radius: 10px;
}
#fav_watch_id {
  display: flex; 
  }
#watch_button {
  margin-left: 60px;
}

  </style>
  <script>
  function validateTextAreaForm() {
    var x = document.forms["movie_comment_form"]["movie_comment"].value;
  if (x == "" || x == null || !x.trim()) {
    document.getElementById("warning_comment").style.display = "block";
    return false;
    }
  } 
  
    </script>
</head>
<body onload="addSingleMovie()">

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="index.php">Kąžiūrėti.lt</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
      <li class="active"><a href="index.php">Home</a></li>
      <li><a href="watchlist.php">Watch list</a></li>
      <li><a href="favouritemovies.php">Favourite movies</a></li>
      <li><a href="about.php">About</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
      <li><a href="#"><?php echo $userSeperate ?><?php echo $userNameDisplayTopRight ?></a> </li>
        <li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> <?php echo $checkLoginTopRight ?></a></li>
      </ul>
    </div>
  </div>
</nav>
  
<div class="container-fluid text-center">    
    
<div class="row content">
    <div class="col-sm-2 sidenav">
        
    </div>
    
    <div class="col-sm-8 text-left w3-mobile"> 
    <div id="movies-searchable"></div>
        <div class="container"></div>
        
        
        
        <div class="w3-container w3-cell w3-mobile">
        <img src="" id="moviePosterClass" class="moviePoster w3-mobile">
        </div>
        <div class="w3-container w3-cell w3-mobile">
        <h1 class="movieTitle w3-mobile"> </h1>
        <div id="movie-title-genres-voteAvg w3-mobile"> 
        <img src="" id="movieBackDropClass" class="movieBackDrop w3-mobile">    
        <h1 id="movieTitleClass" class="movieTitle w3-mobile"> </h1>
        <span id="movieGenresClass" class="movieGenres w3-mobile"></span><br>
        <span id="movieVoteAvgClass" class="movieVoteAvg w3-mobile"> </span><br>
        <div id="fav_watch_id" class="fav_watch_class">
                          <form name="movie_favorite_form" method="post" action="favoritemovieadd.php" >
                          <button type="submit" id="fav_button" name="save_to_favorite" class="btn btn-secondary" <?php echo $favmovie_disabled ?>> Add to Favorite <i class="fa fa-heart" style="color:red"></i></button>
                          

                          
        </form>

                          <form name="movie_watchlist_form" method="post" action="watchlistadd.php" >
                          <button type="submit" id="watch_button" name="save_to_watchlist" class="btn btn-secondary" <?php echo $watchlist_disabled ?>> Add to WatchList <i class="fa fa-plus" aria-hidden="true"></i></button>
                          
        </form>
</div>
        <form name="movie_rating_form" method="post" action="insertrating.php">
          <p id="movie_rating_ptag"><?php echo $disabledTextR ?> </p> 
          <?php 
          if(isset($_SESSION["username"])){
          $sql_count1 = "SELECT COUNT(rating_value) FROM movierating WHERE movie_id = ".$movie_id_url." AND username='".$_SESSION["username"]."'";
         
 
 $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 $result1 = mysqli_query($link, $sql_count1);
 $result2 = $result1->fetch_assoc();

 if ($result2['COUNT(rating_value)'] == 0){

 
 ?>
          <select name="movie_rating_select" id="movie_rating_select">
  <option value="10">10</option>
  <option value="9">9</option>
  <option value="8">8</option>
  <option value="7">7</option>
  <option value="6">6</option>
  <option value="5">5</option>
  <option value="4">4</option>
  <option value="3">3</option>
  <option value="2">2</option>
  <option value="1">1</option>
</select> 
<input type="submit" name="save_movie_rating" class="btn btn-secondary"  value="Rate">
<?php 
 }else {
?>
<select name="movie_rating_select" id="movie_rating_select" disabled>
  <option value="10">10</option>
  <option value="9">9</option>
  <option value="8">8</option>
  <option value="7">7</option>
  <option value="6">6</option>
  <option value="5">5</option>
  <option value="4">4</option>
  <option value="3">3</option>
  <option value="2">2</option>
  <option value="1">1</option>
</select> 
<input type="submit" name="save_movie_rating" class="btn btn-secondary" disabled  value="Rate">
<?php 
 }
}else {

?>
<select name="movie_rating_select" id="movie_rating_select" disabled>
  <option value="10">10</option>
  <option value="9">9</option>
  <option value="8">8</option>
  <option value="7">7</option>
  <option value="6">6</option>
  <option value="5">5</option>
  <option value="4">4</option>
  <option value="3">3</option>
  <option value="2">2</option>
  <option value="1">1</option>
</select> 
<input type="submit" name="save_movie_rating" class="btn btn-secondary" disabled  value="Rate">
<?php

}
?>

 Our user rating:<span id="our_movie_rating" class="movieVoteAvgPhp"> <?php echo $row_avg_rounded ?> </span> <?php echo "Total votes: ".$row_count[0]?>
      </form>
      
        <p id="movieOverviewClass" class="movieOverview w3-mobile"> </p>
        <iframe width="560" height="315" id="trailerMovie" class="w3-mobile" src="" frameborder="0" allowfullscreen></iframe>
        <form onsubmit="return validateTextAreaForm()" name="movie_comment_form" method="post" action="moviecomment.php"><br>
        <div id="warning_comment"class="w3-panel w3-red w3-display-container">
  <span onclick="this.parentElement.style.display='none'"
  class="w3-button w3-red w3-large w3-display-topright">x</span>
  <h3> Error ! </h3>
  <p>Comment can`t be empty!</p>
</div>
		<span id="movie_comment_ptag">Comment this movie |</span> <span><?php echo count($comment_array)?> </span><span> <span> <?php if(count($comment_array) === 1){
      echo "Comment";
    }else {
      echo "Comments";
    } ?></span> <br>
    <textarea name="movie_comment" rows="5" cols="40" <?php echo $disabled ?> ><?php echo $disabledText ?></textarea>
    <input type="submit" name="save_comment_movie" class="btn" <?php echo $disabled ?> value="Comment">
</form>
    <div id="movie_rating_section"> </div>
    <div id="movie_comment_section"><?php $comment_array_length = count($comment_array);
$i = 0;
while ($i < $comment_array_length){
  echo "<div id="."comment_single>".$comment_array[$i]."</div><br>";
  $i++;
}?></div>
        </div>
      
        
      </div>
     
        
        
    </div>
    <div class="col-sm-2 sidenav">
      
    </div>
  </div>
</div>

<footer class="container-fluid text-center">
  <p class="copyright">&copy; 2021 <a href="http://sapola.lt">sapola.lt</a></p>
</footer>
<script src="assets/apiTransaction.js"></script>
  <script src="assets/app.js"></script>
</body>
</html>
