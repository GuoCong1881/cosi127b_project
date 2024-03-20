<?php include 'title.php'; ?>
<?php include 'head.php'; ?>
<body>
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