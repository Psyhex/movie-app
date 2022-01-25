<?php
// Initialize the session
session_start();
 
// Check if the user is logged in
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
  
  $checkLoginTopRight = " Login";
  $userNameDisplayTopRight = "";
  $userSeperate = "";
}else {
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
section {
    display: flex;
    width: 100%;
    overflow-x: auto;
}
section img {
    width: 150px;
    transition: 250ms all;
    border-radius: 10px;
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
font-size: 13px;
display: block;
}
.imgclass:hover {
    cursor: pointer;
    opacity: 50%;
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
.sectionsingle{
  background-color:lightgray;
  border-radius: 10px;
}

  </style>
</head>
<body>

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
        <li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> <?php echo $checkLoginTopRight ?></a> </li>
      
      </ul>
    </div>
  </div>
</nav>
<div class="w3-cell-row w3-mobile"></div>
<div class="container-fluid text-center">    
  <div class="row content">
    <div class="col-sm-2 sidenav">
        <form>
            <div class="form-group">
                <input type="text" id="inputValue">
            </div> 
            <button type="submit" id="search">Search a movie</button>
     </form>
    </div>
    <div class="col-sm-8 text-left"> 
        <div class="container">
               
        </div>
    
    
    
    
        <div id="kontentas"></div>
        <div id="movieid"></div>
        <div id="movies-searchable"></div>
        <div id="movies-container"></div>
        
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
