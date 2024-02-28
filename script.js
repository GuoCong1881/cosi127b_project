function getMovies() {
    // Send an AJAX request to the PHP script to fetch movies
    fetch("movies.php")
        .then(response => response.text())
        .then(data => {
            document.getElementById("results").innerHTML = data;
        })
        .catch(error => {
            console.error("Error fetching movies:", error);
        });
}

function getActors() {
    // Send an AJAX request to the PHP script to fetch actors
    fetch("actors.php")
        .then(response => response.text())
        .then(data => {
            document.getElementById("results").innerHTML = data;
        })
        .catch(error => {
            console.error("Error fetching actors:", error);
        });
}

function likeMovie() {
    const email = document.getElementById("email").value;
    // Implement logic to check if email is valid and send data to like_movie.php
}