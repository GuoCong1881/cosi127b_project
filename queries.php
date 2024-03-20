<?php include 'title.php'; ?>
<?php include 'head.php'; ?>
<body>
<div class="container">
        <h3>Query 1: List all the tables in the database</h3>
        <form method="post" action="queries.php">
            <button class="btn btn-primary" type="submit" name="listTables">List Tables</button>
        </form>
        
        <h3>Query 2: Search Motion Picture by Motion picture name</h3>
        <form method="post" action="queries.php">
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Enter motion picture name" name="movieName">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit" name="searchMovie">Search</button>
                </div>
            </div>
        </form>
        
        <h3>Query 3: Find the movies that have been liked by a specific user's email</h3>
        <form method="post" action="queries.php">
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Enter user email" name="userEmail">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit" name="findLikedMovies">Find Liked Movies</button>
                </div>
            </div>
        </form>
        
        <h3>Query 4: Search motion pictures by their shooting location country</h3>
        <form method="post" action="queries.php">
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Enter shooting location country" name="country">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit" name="searchMovieByCountry">Search</button>
                </div>
            </div>
        </form>
        
        <h3>Query 5: List all directors who have directed TV series shot in a specific zip code</h3>
        <form method="post" action="queries.php">
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Enter zip code" name="zipCode">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit" name="listDirectorsByZipCode">List Directors</button>
                </div>
            </div>
        </form>
        
        <h3>Query 6: Find the people who have received more than "k" awards for a single motion picture in the same year</h3>
        <form method="post" action="queries.php">
            <div class="input-group mb-3">
                <input type="number" class="form-control" placeholder="Enter number of awards (k)" name="k">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit" name="findPeopleByAwards">Find People</button>
                </div>
            </div>
        </form>
        
        <h3>Query 7: Find the youngest and oldest actors to win at least one award</h3>
        <form method="post" action="queries.php">
            <button class="btn btn-primary" type="submit" name="findYoungestOldestActors">Find Youngest and Oldest Actors</button>
        </form>
        
        <h3>Query 8: Find the American Producers who had a box office collection of more than or equal to "X" with a budget less than or equal to "Y"</h3>
        <form method="post" action="queries.php">
            <div class="input-group mb-3">
                <input type="number" class="form-control" placeholder="Enter minimum box office collection (X)" name="X">
                <input type="number" class="form-control" placeholder="Enter maximum budget (Y)" name="Y">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit" name="findAmericanProducers">Find American Producers</button>
                </div>
            </div>
        </form>
        
        <h3>Query 9: List the people who have played multiple roles in a motion picture where the rating is more than "X"</h3>
        <form method="post" action="queries.php">
            <div class="input-group mb-3">
                <input type="number" step="0.1" class="form-control" placeholder="Enter minimum rating (X)" name="X">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit" name="listPeopleByRating">List People</button>
                </div>
            </div>
        </form>
        
        <h3>Query 10: Find the top 2 rated thriller movies that were shot exclusively in Boston</h3>
        <form method="post" action="queries.php">
            <button class="btn btn-primary" type="submit" name="findTopThrillerMovies">Find Top Thriller Movies</button>
        </form>
        
        <h3>Query 11: Find all the movies with more than "X" likes by users of age less than "Y"</h3>
        <form method="post" action="queries.php">
            <div class="input-group mb-3">
                <input type="number" class="form-control" placeholder="Enter minimum likes (X)" name="X">
                <input type="number" class="form-control" placeholder="Enter maximum user age (Y)" name="Y">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit" name="findMoviesByLikesAndAge">Find Movies</button>
                </div>
            </div>
        </form>
        
        <h3>Query 12: Find the actors who have played a role in both "Marvel" and "Warner Bros" productions</h3>
        <form method="post" action="queries.php">
            <button class="btn btn-primary" type="submit" name="findActorsInProductions">Find Actors</button>
        </form>
        
        <h3>Query 13: Find the motion pictures that have a higher rating than the average rating of all comedy motion pictures</h3>
        <form method="post" action="queries.php">
            <button class="btn btn-primary" type="submit" name="findMoviesAboveComedyAverage">Find Movies</button>
        </form>
        
        <h3>Query 14: Find the top 5 movies with the highest number of people playing a role in that movie</h3>
        <form method="post" action="queries.php">
            <button class="btn btn-primary" type="submit" name="findTopMoviesByPeopleCount">Find Top Movies</button>
        </form>
        
        <h3>Query 15: Find actors who share the same birthday</h3>
        <form method="post" action="queries.php">
            <button class="btn btn-primary" type="submit" name="findActorsWithSameBirthday">Find Actors</button>
        </form>
    </div>

    <div class="container">
        <?php

            // Query 1: List all the tables in the database
            if (isset($_POST['listTables'])) {
                $query = "SHOW TABLES";
                $tables = executeQuery($conn, $query);
                displayTable(['Tables'], $tables);
            }

            // Query 2: Search Motion Picture by Motion picture name
            if (isset($_POST['searchMovie'])) {
                $movieName = $_POST['movieName'];
                $query = "SELECT name, rating, production, budget FROM MotionPicture WHERE name LIKE '%$movieName%'";
                $movies = executeQuery($conn, $query);
                displayTable(['Name', 'Rating', 'Production', 'Budget'], $movies);
            }

            // Query 3: Find the movies that have been liked by a specific user's email
            if (isset($_POST['findLikedMovies'])) {
                $userEmail = $_POST['userEmail'];
                $query = "SELECT mp.name, mp.rating, mp.production, mp.budget FROM MotionPicture mp JOIN Likes l ON mp.id = l.mpid WHERE l.uemail = '$userEmail'";
                $movies = executeQuery($conn, $query);
                displayTable(['Name', 'Rating', 'Production', 'Budget'], $movies);
            }

            // Query 4: Search motion pictures by their shooting location country
            if (isset($_POST['searchMovieByCountry'])) {
                $country = $_POST['country'];
                $query = "SELECT DISTINCT mp.name FROM MotionPicture mp JOIN Location l ON mp.id = l.mpid WHERE l.country = '$country'";
                $movies = executeQuery($conn, $query);
                displayTable(['Name'], $movies);
            }

            // Query 5: List all directors who have directed TV series shot in a specific zip code
            if (isset($_POST['listDirectorsByZipCode'])) {
                $zipCode = $_POST['zipCode'];
                $query = "SELECT DISTINCT p.name AS director_name, mp.name AS series_name
                FROM People p
                JOIN Role r ON p.id = r.pid
                JOIN MotionPicture mp ON r.mpid = mp.id
                JOIN Location l ON mp.id = l.mpid
                WHERE l.zip = '$zipCode'
                AND r.role_name = 'Director'
                AND EXISTS (SELECT 1 FROM Series s WHERE s.mpid = mp.id);
                ";
                $directors = executeQuery($conn, $query);
                displayTable(['Director', 'TV Series'], $directors);
            }

            // Query 6: Find the people who have received more than "k" awards for a single motion picture in the same year
            if (isset($_POST['findPeopleByAwards'])) {
                $k = $_POST['k'];
                $query = "SELECT p.name AS person_name, mp.name AS motion_picture_name, a.award_year, COUNT(a.award_name) AS award_count
                FROM People p
                JOIN Award a ON p.id = a.pid
                JOIN MotionPicture mp ON a.mpid = mp.id
                GROUP BY p.name, mp.name, a.award_year
                HAVING COUNT(a.award_name) > '$k'";
                $people = executeQuery($conn, $query);
                displayTable(['Name', 'Motion Picture', 'Award Year', 'Award Count'], $people);
            }

            // Query 7: Find the youngest and oldest actors to win at least one award
            if (isset($_POST['findYoungestOldestActors'])) {
                $query = "(SELECT p.name, MIN(YEAR(a.award_year) - YEAR(p.dob)) AS age
                FROM People p
                JOIN Role r ON p.id = r.pid
                JOIN Award a ON p.id = a.pid
                WHERE r.role_name = 'Actor'
                AND a.award_name = 'Best Actor'
                GROUP BY p.id
                ORDER BY age ASC
                LIMIT 1)
                UNION
                (SELECT p.name, MAX(YEAR(a.award_year) - YEAR(p.dob)) AS age
                FROM People p
                JOIN Role r ON p.id = r.pid
                JOIN Award a ON p.id = a.pid
                WHERE r.role_name = 'Actor'
                AND a.award_name = 'Best Actor'
                GROUP BY p.id
                ORDER BY age DESC
                LIMIT 1);";
                $awardWinningActors = executeQuery($conn, $query);
                displayTable(['Name', 'Age'], $awardWinningActors);
            }
            
            // Query 8: Find the American Producers who had a box office collection of more than or equal to "X" with a budget less than or equal to "Y"
            if (isset($_POST['findAmericanProducers'])) {
                $X = $_POST['X'];
                $Y = $_POST['Y'];
                $query = "SELECT p.name AS producer_name, mp.name AS movie_name, m.boxoffice_collection, mp.budget
                FROM People p
                JOIN Role r ON p.id = r.pid
                JOIN MotionPicture mp ON r.mpid = mp.id
                JOIN Movie m ON mp.id = m.mpid
                WHERE p.nationality = 'USA'
                AND r.role_name = 'Producer'
                AND m.boxoffice_collection >= $X
                AND mp.budget <= $Y";
                $producers = executeQuery($conn, $query);
                displayTable(['Producer', 'Movie', 'Box Office Collection', 'Budget'], $producers);
            }

            // Query 9: List the people who have played multiple roles in a motion picture where the rating is more than "X"
            if (isset($_POST['listPeopleByRating'])) {
                $X = $_POST['X'];
                $query = "SELECT p.name AS PersonName, mp.name AS MotionPictureName, COUNT(r.role_name) AS NumberOfRoles
                FROM People p
                JOIN Role r ON p.id = r.pid
                JOIN MotionPicture mp ON r.mpid = mp.id
                WHERE mp.rating > $X
                GROUP BY p.id, mp.id
                HAVING COUNT(r.role_name) > 1
                ORDER BY p.name, mp.name;";
                $people = executeQuery($conn, $query);
                displayTable(['Name', 'Motion Picture', 'Role Count'], $people);
            }

            // Query 10: Find the top 2 rated thriller movies that were shot exclusively in Boston
            if (isset($_POST['findTopThrillerMovies'])) {
                $query = "SELECT mp.name, mp.rating
                FROM MotionPicture mp
                JOIN Genre g ON mp.id = g.mpid
                JOIN Location l ON mp.id = l.mpid
                WHERE g.genre_name = 'thriller'
                AND l.city = 'Boston'
                GROUP BY mp.id
                HAVING COUNT(DISTINCT l.city) = 1
                ORDER BY mp.rating DESC
                LIMIT 2;";
                $movies = executeQuery($conn, $query);
                displayTable(['Name', 'Rating'], $movies);
            }

            // Query 11: Find all the movies with more than "X" likes by users of age less than "Y"
            if (isset($_POST['findMoviesByLikesAndAge'])) {
                $X = $_POST['X'];
                $Y = $_POST['Y'];
                $query = "SELECT mp.name, COUNT(l.uemail) AS likes_count
                FROM MotionPicture mp
                JOIN Likes l ON mp.id = l.mpid
                JOIN User u ON l.uemail = u.email
                WHERE u.age < $Y
                GROUP BY mp.id
                HAVING likes_count > $X
                ORDER BY likes_count DESC;";
                $movies = executeQuery($conn, $query);
                displayTable(['Name', 'Like Count'], $movies);
            }

            // Query 12: Find the actors who have played a role in both "Marvel" and "Warner Bros" productions
            if (isset($_POST['findActorsInProductions'])) {
                $query = "SELECT DISTINCT p.name AS actor_name, mp.name AS movie_name
                FROM People p
                JOIN Role r ON p.id = r.pid
                JOIN MotionPicture mp ON r.mpid = mp.id
                WHERE p.id IN (
                    SELECT p.id
                    FROM People p
                    JOIN Role r ON p.id = r.pid
                    JOIN MotionPicture mp ON r.mpid = mp.id
                    WHERE mp.production = 'Marvel'
                    INTERSECT
                    SELECT p.id
                    FROM People p
                    JOIN Role r ON p.id = r.pid
                    JOIN MotionPicture mp ON r.mpid = mp.id
                    WHERE mp.production = 'Warner Bros'
                )
                ORDER BY p.name, mp.name;";
                $actors = executeQuery($conn, $query);
                displayTable(['Actor', 'Motion Picture'], $actors);
            }

            // Query 13: Find the motion pictures that have a higher rating than the average rating of all comedy motion pictures
            if (isset($_POST['findMoviesAboveComedyAverage'])) {
                $query = "SELECT name, rating FROM MotionPicture WHERE rating > (SELECT AVG(rating) FROM MotionPicture mp JOIN Genre g ON mp.id = g.mpid WHERE g.genre_name = 'comedy') ORDER BY rating DESC";
                $movies = executeQuery($conn, $query);
                displayTable(['Name', 'Rating'], $movies);
            }

            // Query 14: Find the top 5 movies with the highest number of people playing a role in that movie
            if (isset($_POST['findTopMoviesByPeopleCount'])) {
                $query = "SELECT mp.name, COUNT(DISTINCT r.pid) as people_count, COUNT(*) as role_count FROM MotionPicture mp JOIN Role r ON mp.id = r.mpid GROUP BY mp.id ORDER BY people_count DESC, role_count DESC LIMIT 5";
                $movies = executeQuery($conn, $query);
                displayTable(['Name', 'People Count', 'Role Count'], $movies);
            }

            // Query 15: Find actors who share the same birthday
            if (isset($_POST['findActorsWithSameBirthday'])) {
                $query = "SELECT p1.name as actor1, p2.name as actor2, p1.dob as birthday FROM People p1 JOIN People p2 ON p1.dob = p2.dob AND p1.id < p2.id WHERE p1.id IN (SELECT pid FROM Role WHERE role_name = 'actor') AND p2.id IN (SELECT pid FROM Role WHERE role_name = 'actor')";
                $actors = executeQuery($conn, $query);
                displayTable(['Actor 1', 'Actor 2', 'Birthday'], $actors);
            }
            $conn = null;
        ?>
    </div>

</body>