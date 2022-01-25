<?php
// Initialize the session
require_once "config.php";
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
  $loginLink =   '<a href="login.php">Log in here</a>';
  $favouriteMoviesCheckLog = str_replace("Your Favourite Movies","You must be loggedin to have a favourite movies list | $loginLink","Your Favourite Movies");
  $checkLoginTopRight = " Login";
  $userSeperate = "";
  $userNameDisplayTopRight = "";
}else {
  $favouriteMoviesCheckLog = "";
  $checkLoginTopRight = str_replace(" Login","Logout"," Login");
  $userSeperate = "Welcome, ";
  $userNameDisplayTopRight = htmlspecialchars($_SESSION["username"]);
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

  <script src="assets/apiTransaction.js"></script>
  <script src="assets/app.js"></script>
  <script>
  
  

  var xmlhttpForWatchList = new XMLHttpRequest();
  xmlhttpForWatchList.onreadystatechange = function() {
  if (this.readyState == 4 && this.status == 200) {
    var userWatchList = JSON.parse(this.responseText);
  //  document.getElementById("user_info_div").innerHTML = userWatchList.length;
    console.log(userWatchList);
        
            var toAdd = document.getElementById("movie_info_div");
            var xmlhttp = [];
            var myObj = [];
            for (let i = 0 ; i < userWatchList.length; i++){
              console.log("Movie Id from db  " + userWatchList[i].movie_id);
              console.log("from db colum username " + userWatchList[i].username);
              console.log("from db ID collum number " + userWatchList[i].id );
              xmlhttp[i] = new XMLHttpRequest();
              xmlhttp[i].onreadystatechange = function() {
              if (this.readyState == 4 && this.status == 200) {
              myObj[i] = JSON.parse(this.responseText);
              //document.getElementById("movie_info_div").innerHTML = myObj;
              console.log("Movie title from url " + myObj[i].title);

              //document.getElementById("moviePosterClass").src = IMAGE_URL+"/"+jsonObj.poster_path;  pavizdys su paveiksleliu
              //
              var newDiv = document.createElement('div')
              newDiv.id = 'movie_info_single';
              //toAdd.appendChild(newDiv);
              if (myObj[i].poster_path){
              const img = document.createElement('img');
              img.src = IMAGE_URL + myObj[i].poster_path;
              img.setAttribute('data-movie-id', myObj[i].id);
              img.classList.add('imgclass');
              toAdd.appendChild(newDiv);
              newDiv.appendChild(img);
              }
              if (myObj[i].title){
                const movieTitle = document.createElement('h4');
                movieTitle.innerHTML =  myObj[i].title;
                toAdd.appendChild(newDiv);
                newDiv.appendChild(movieTitle);
              }
              
              
       }
};
xmlhttp[i].open("GET", `https://api.themoviedb.org/3/movie/${userWatchList[i].movie_id}?api_key=c52d26892911f6d1bfc7c065be76b9d3`, true);
xmlhttp[i].send();

            }


        


  }
};
xmlhttpForWatchList.open("GET", "/favjson.php", true);
xmlhttpForWatchList.send();
console.log(IMAGE_URL);
  
document.onclick = function(event) {

const target = event.target;


 if (target.className.toLowerCase() === 'imgclass'  ){
  window.location.href = "moviepage.php?id="+target.dataset.movieId;
  
}           
    if(target.className.toLowerCase() === 'logoplace'){
        window.location.href = "index.php";
     }
} 

  </script>

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
    transform: scale(1.1);
}
.green {
  color: green;
}
.red {
  color: red;
}
.orange{
 color: orange;
}
#movie_info_div {
    display: flex;
    flex-wrap: wrap;
    width: 100%;
    
}
#movie_info_single {
  margin-left: 40px;
  width: 300px;
}
.imgclass {
  transition: transform .2s;
  height: 400px;
  width: 300px;
}
h4 {
  text-align: center;
}
  </style>
</head>
<body >

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
        <div class="container"> </div>
        
        <h1 id="favouriteMoviesId" class="my-5"><b></b>Your Favourite Movies</h1>
        <p> <?php echo $favouriteMoviesCheckLog  ?> </p>
        
        
      
        <div id="movie_info_div"> </div>
        
        
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