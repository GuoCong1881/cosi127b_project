<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!-- Bootstrap JS dependencies -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COSI 127b</title>
</head>
<body>
    <div class="container">
        <h1 style="text-align:center">COSI 127b</h1><br>
        <h3 style="text-align:center">Connecting Front-End to MySQL DB</h3><br>
    </div>
    
    <div class="container">
        
        <div class="container">
            <form id="rateLimitForm" method="post" action="index.php">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Enter minimum rating" name="inputRate" id="inputRate">
                    <div class="input-group-append">
                        <!-- Button to select movies according to ratings -->
                        <button class="btn btn-outline-secondary" type="submit" name="searchRateMovie">Query</button>
                    </div>
                    <!-- Button to view all movies -->
                    <a class="btn btn-primary" href="index.php?query=view_movies" role="button">View All Movies</a>
                </div>
            </form>
        </div>
        
        <!-- Button to view all actors -->
        
        <div class="container">
            <form id="searchActorByNameForm" method="post" action="index.php">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Enter actor's name" name="inputActorName" id="inputActorName">
                    <div class="input-group-append">
                        <!-- Button to select movies according to ratings -->
                        <button class="btn btn-outline-secondary" type="submit" name="searchNameActor">Query</button>
                    </div>
                    <!-- Button to view all actors -->
                    <a class="btn btn-primary" href="index.php?query=view_actors" role="button">View All Actors</a>
                </div>
            </form>
        </div>
    </div>
    <div class="container">
        <h1>Like a Movie</h1>
        <form id="likeMovieForm" method="post" action="index.php">
            <div class="form-group">
                <label for="userEmail">Your Email:</label>
                <input type="email" class="form-control" id="userEmail" name="userEmail" required>
            </div>
            <div class="form-group">
                <label for="movieId">Movie ID:</label>
                <input type="text" class="form-control" id="movieId" name="movieId" required>
            </div>
            <button type="submit" class="btn btn-success" name="likeMovie">Like Movie</button>
        </form>
    </div>

    <div class="container">
        <?php
            function connectToDatabase($servername, $username, $password, $dbname) {
                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $conn;
            }

            function executeQuery($conn, $query) {
                $stmt = $conn->prepare($query);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }

            function displayTable($headers, $rows) {
                echo "<table class='table table-md table-bordered' style='table-layout: auto; width: 100%;'>";
                echo "<thead class='thead-dark' style='text-align: center'>";
                echo "<tr>";
                foreach ($headers as $header) {
                    echo "<th class='col-md-2' style='overflow: hidden; text-overflow: ellipsis; white-space: nowrap;'>$header</th>";
                }
                echo "</tr></thead>";
                foreach ($rows as $row) {
                    echo "<tr>";
                    foreach ($row as $cell) {
                        echo "<td style='text-align:center; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;'>$cell</td>";
                    }
                    echo "</tr>";
                }
                echo "</table>";
            }

            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "COSI127b";

            $conn = connectToDatabase($servername, $username, $password, $dbname);

            if(isset($_POST['likeMovie'])) {
                $userEmail= $_POST['userEmail'];
                $movieId = $_POST['movieId'];
                try {
                    // Connect to the database
                    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
                    // Check if the user exists in the 'User' table
                    $stmtCheckUser = $conn->prepare("SELECT * FROM User WHERE email = :userEmail");
                    $stmtCheckUser->bindParam(':userEmail', $userEmail, PDO::PARAM_STR);
                    $stmtCheckUser->execute();
    
                    // Fetch the result
                    $userResult = $stmtCheckUser->fetch(PDO::FETCH_ASSOC);
    
                    if ($userResult !== false) {
                        // User exists in the 'User' table, proceed with checking likes
                        // Check if the user already liked the movie to avoid duplicate entries
                        $stmtCheckLike = $conn->prepare("SELECT * FROM Likes WHERE uemail = :userEmail AND mpid = :movieId");
                        $stmtCheckLike->bindParam(':userEmail', $userEmail, PDO::PARAM_STR);
                        $stmtCheckLike->bindParam(':movieId', $movieId, PDO::PARAM_INT);
                        $stmtCheckLike->execute();
    
                        if ($stmtCheckLike->rowCount() == 0) {
                            // User has not liked the movie yet, proceed to insert into 'Likes' table
                            $stmtInsertLike = $conn->prepare("INSERT INTO Likes (uemail, mpid) VALUES (:userEmail, :movieId)");
                            $stmtInsertLike->bindParam(':userEmail', $userEmail, PDO::PARAM_STR);
                            $stmtInsertLike->bindParam(':movieId', $movieId, PDO::PARAM_INT);
                            $stmtInsertLike->execute();
    
                            echo "<p>Thank you for liking the movie!</p>";
                        } else {
                            // User has already liked the movie
                            echo "<p>You have already liked this movie.</p>";
                        }
                    } else {
                        // User does not exist in the 'User' table
                        echo "<p>Error: User does not exist. Cannot like the movie.</p>";
                    }
                } catch(PDOException $e) {
                    echo "Error: " . $e->getMessage();
                } finally {
                    // Close the database connection
                    $conn = null;
                }
            }

            if(isset($_POST['searchRateMovie'])) {
                $rate= $_POST['inputRate'];
                $query = "SELECT * FROM MotionPicture WHERE rating >= $rate";
                $movies = executeQuery($conn, $query);
                displayTable(['ID', 'Name', 'Rating', 'Production', 'Budget'], $movies);
            }

            if(isset($_POST['searchNameActor'])) {
                $name= $_POST['inputActorName'];
                $query = "SELECT * FROM People WHERE name LIKE '%$name%'";
                $actors = executeQuery($conn, $query);
                displayTable(['ID', 'Name', 'Nationality', 'DOB', 'Gender'], $actors);
            }

            if(isset($_GET['query']) && $_GET['query'] == 'view_movies') {
                $query = "SELECT * FROM MotionPicture";
                $movies = executeQuery($conn, $query);
                displayTable(['ID', 'Name', 'Rating', 'Production', 'Budget'], $movies);
            }

            if(isset($_GET['query']) && $_GET['query'] == 'view_actors') {
                $query = "SELECT * FROM People";
                $actors = executeQuery($conn, $query);
                displayTable(['ID', 'Name', 'Nationality', 'DOB', 'Gender'], $actors);
            }

            $conn = null;
        ?>
    </div>

</body>
</html>
