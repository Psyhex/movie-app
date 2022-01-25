const buttonElement = document.querySelector('#search');
const inputElement = document.querySelector('#inputValue');
const movieSearchable = document.querySelector('#movies-searchable');
const moviesContainer = document.querySelector('#movies-container');

function movieSection(movies){
    const section = document.createElement('section');
    section.classList = 'section';
    
    movies.map((movie) => {
        const sectionsingle = document.createElement('div');
        sectionsingle.classList = 'sectionsingle';
        
        if (movie.poster_path){
            const img = document.createElement('img');
            img.src = IMAGE_URL + movie.poster_path;
            img.setAttribute('data-movie-id', movie.id);
            img.classList.add('imgclass');
            section.appendChild(sectionsingle);
            sectionsingle.appendChild(img);
            
        }
        if (movie.title){
            const movieTitle = document.createElement('h3');
            movieTitle.innerHTML = movie.title;
            movieTitle.classList.add("movie-title");
            //section.appendChild(movieTitle);
            section.appendChild(sectionsingle);
            sectionsingle.appendChild(movieTitle);
        }
        if (movie.release_date){
            const movieRealease_date = document.createElement('span');
            movieRealease_date.classList.add("release_date");
            movieRealease_date.innerHTML = movie.release_date;
            //section.appendChild(movieRealease_date);
            section.appendChild(sectionsingle);
            sectionsingle.appendChild(movieRealease_date);
        }
        if (movie.vote_average){
            const movieVoteavg = document.createElement('span');
            movieVoteavg.classList.add("movieVoteavg");
            movieVoteavg.classList.add(`${getClassByRate(movie.vote_average)}`);
            movieVoteavg.innerHTML = movie.vote_average;
           // section.appendChild(movieVoteavg);
            section.appendChild(sectionsingle);
            sectionsingle.appendChild(movieVoteavg);
            function getClassByRate(vote) {
                if (vote >= 7) {
                    return "green";
                } else if (vote >= 5) {
                    return "orange";
                } else {
                    return "red";
                }
            }
        }
        
    })
    return section;
}
//-------------------------------------------------------------------
function createMovieContainer(movies, title = ''){
    const movieElement = document.createElement('div');
    movieElement.setAttribute('class', 'movie');

    const header = document.createElement('h2');
    header.innerHTML = title;

    const content = document.createElement('div');
    content.classList = 'content';
    

    const section = movieSection(movies);
    

    movieElement.appendChild(header);
    movieElement.appendChild(section);
    movieElement.appendChild(content);
    return movieElement;

}
//-------------------------------------------------------------------
function renderSearchMovies(data){
        movieSearchable.innerHTML='';
        const movies = data.results;
        const movieBlock = createMovieContainer(movies);
        movieSearchable.appendChild(movieBlock);
        //console.log('Data: ', data);
}
//-------------------------------------------------------------------
function renderMovies(data){

    const movies = data.results;
    const movieBlock = createMovieContainer(movies,  this.title);
    if (moviesContainer != null){
        moviesContainer.appendChild(movieBlock);
    }
}
//-------------------------------------------------------------------
function handleError(error){
    console.log('Eror: ', error);
}
//-------------------------------------------------------------------
buttonElement.onclick = function(event){
    event.preventDefault();
    const value = inputElement.value;
    searchMovie(value);
    inputElement.value = '';
    console.log('Value:',value);
}

//-------------------------------------------------------------------
function addSingleMovie() {
    
    const url_str = window.location.href
    const urlas = new URL(url_str);
    const search_params = urlas.searchParams; 
    let singleMovieId = search_params.get('id');
    
    
    const path = `/movie/${singleMovieId}`;
    const url = generateUrl(path);
    const videoUrl = `https://api.themoviedb.org/3/movie/${singleMovieId}/videos?api_key=c52d26892911f6d1bfc7c065be76b9d3`;
    
        var xhttp = new XMLHttpRequest();
         xhttp.onreadystatechange = function() {

           
            if (xhttp.readyState == 4  ) {
                
                var jsonObj = JSON.parse(xhttp.responseText);               
                const genresMas = jsonObj.genres;
                const genresLength = genresMas.length;


                for (let i = 0; i < genresLength; i++){
                genresMas[i].name + " | ";
                    console.log(genresMas[i].name);
                    document.getElementById("movieGenresClass").innerHTML += genresMas[i].name+" | ";
                }

                if(jsonObj.backdrop_path != null){
                    document.getElementById("movieBackDropClass").src = IMAGE_URL+"/"+jsonObj.backdrop_path;
                }

                if(jsonObj.release_date != 0){
                document.getElementById("movieTitleClass").innerHTML = jsonObj.title+" ("+jsonObj.release_date.substring(0,4)+")";
                }else {
                    document.getElementById("movieTitleClass").innerHTML = jsonObj.title;
                }

                document.getElementById("movieOverviewClass").innerHTML = jsonObj.overview;
                if (jsonObj.vote_average == 0){
                    document.getElementById("movieVoteAvgClass").innerHTML = "No rating";
                }else {
                    document.getElementById("movieVoteAvgClass").innerHTML = "Rating: "+jsonObj.vote_average;
                    document.getElementById("movieVoteAvgClass").classList.add(getClassByRate(jsonObj.vote_average));

                    function getClassByRate(vote) {
                        if (vote >= 7) {
                            return "green";
                        } else if (vote >= 5) {
                            return "orange";
                        } else {
                            return "red";
                        }
                    }
                }
                document.getElementById("moviePosterClass").src = IMAGE_URL+"/"+jsonObj.poster_path; 
                var our_rating = document.getElementById("our_movie_rating").innerHTML;
                if (our_rating == 0){
                    document.getElementById("our_movie_rating").innerHTML = "No rating";
                }
                document.getElementById("our_movie_rating").classList.add(getClassByRate(our_rating));
                function getClassByRate(vote) {
                    if (vote >= 7) {
                        return "green";
                    } else if (vote >= 5) {
                        return "orange";
                    } else {
                        return "red";
                    } 
                    
                }
             }
          }
          
          xhttp.open("GET", url, true);
          xhttp.send();
          
          var x = new XMLHttpRequest();
          x.onreadystatechange = function() {
          
              if (x.readyState == 4  ) {
                  var jsonObj1 = JSON.parse(x.responseText);
                  console.log(jsonObj1.results[0].key);
                 document.getElementById("trailerMovie").src = "https://www.youtube.com/embed/"+jsonObj1.results[0].key;
            }
        }
              x.open("GET", videoUrl, true);
              x.send();
              //---------------------------------------------------------------------Neveikia meta klaida
    //           var xmlhttp = new XMLHttpRequest();
    //   xmlhttp.onreadystatechange = function() {
    //     if (this.readyState == 4 && this.status == 200) {
    //       document.getElementById("movie_comment_section").innerHTML = this.responseText;
    //     }
    //   }
    //   xmlhttp.open("GET","commentdisplay.php",true);
    //   xmlhttp.send();
}
//-------------------------------------------------------------------
document.onclick = function(event) {

    const target = event.target;

    
     if (target.className.toLowerCase() === 'imgclass'  ){
      window.location.href = "moviepage.php?id="+target.dataset.movieId;
      
    }           
        if(target.className.toLowerCase() === 'logoplace'){
            window.location.href = "index.php";
         }
} 



//-------------------------------------------------------------------
//addElement();
//getUpcomingMovies();
//getTopRatedMovies();
getPopularMovie();
//getNowPlaying();
