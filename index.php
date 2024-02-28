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
        <form id="ageLimitForm" method="post" action="index.php">
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Enter minimum age" name="inputAge" id="inputAge">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit" name="submitted" id="button-addon2">Query</button>
                </div>
            </div>
        </form>
    </div>
    
    <div class="container">
        <!-- Button to view all movies -->
        <a class="btn btn-primary" href="index.php?query=view_movies" role="button">View All Movies</a>
        
        <!-- Button to view all actors -->
        <a class="btn btn-primary" href="index.php?query=view_actors" role="button">View All Actors</a>
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
            // ... (your existing PHP code)
               // we want to check if the submit button has been clicked (in our case, it is named Query)
               if(isset($_POST['submitted']))
               {
                   // set age limit to whatever input we get
                   // ideally, we should do more validation to check for numbers, etc. 
                  $ageLimit = $_POST["inputAge"]; 
               }
               else
               {
                   // if the button was not clicked, we can simply set age limit to 0 
                   // in this case, we will return everything
                   $ageLimit = 0;
               }
       
               // we will now create a table from PHP side 
               echo "<table class='table table-md table-bordered'>";
               echo "<thead class='thead-dark' style='text-align: center'>";
       
               // initialize table headers
               // YOU WILL NEED TO CHANGE THIS DEPENDING ON TABLE YOU QUERY OR THE COLUMNS YOU RETURN
                echo "<tr><th class='col-md-2'>Firstname</th><th class='col-md-2'>Lastname</th></tr></thead>";
       
               // generic table builder. It will automatically build table data rows irrespective of result
               class TableRows extends RecursiveIteratorIterator {
                   function __construct($it) {
                       parent::__construct($it, self::LEAVES_ONLY);
                   }
       
                   function current() {
                       return "<td style='text-align:center'>" . parent::current(). "</td>";
                   }
       
                   function beginChildren() {
                       echo "<tr>";
                   }
       
                   function endChildren() {
                       echo "</tr>" . "\n";
                   }
               }
       
               // SQL CONNECTIONS
               $servername = "localhost";
               $username = "root";
               $password = "";
               $dbname = "COSI127b";
       
               try {
                   // We will use PDO to connect to MySQL DB. This part need not be 
                   // replicated if we are having multiple queries. 
                   // initialize connection and set attributes for errors/exceptions
                   $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                   $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
       
                   // prepare statement for executions. This part needs to change for every query
                   $stmt = $conn->prepare("SELECT first_name, last_name FROM guests where age>=$ageLimit");
       
                   // execute statement
                   $stmt->execute();
       
                   // set the resulting array to associative. 
                   $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
       
                   // for each row that we fetched, use the iterator to build a table row on front-end
                   foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) {
                       echo $v;
                   }
               }
               catch(PDOException $e) {
                   echo "Error: " . $e->getMessage();
               }
               echo "</table>";
               // destroy our connection
               $conn = null;

        // Check if 'likeMovie' button is clicked
        if(isset($_POST['likeMovie'])) {
            // Get user email and movie ID from the form
            $userEmail = $_POST['userEmail'];
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


        // Check if 'view_movies' query parameter is present
        if(isset($_GET['query']) && $_GET['query'] == 'view_movies') {
            try {
                // Connect to the database
                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Prepare and execute the SQL query to select all movies
                $stmt = $conn->prepare("SELECT * FROM MotionPicture");
                $stmt->execute();

                // Fetch all rows
                $movies = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // Display the movies
                echo "<h1>All Movies</h1>";
                echo "<table class='table table-md table-bordered'>";
                echo "<thead class='thead-dark' style='text-align: center'>";
                echo "<tr><th>ID</th><th>Name</th><th>Rating</th><th>Production</th><th>Budget</th></tr></thead>";
                
                foreach($movies as $movie) {
                    echo "<tr>";
                    echo "<td style='text-align:center'>" . $movie['id'] . "</td>";
                    echo "<td style='text-align:center'>" . $movie['name'] . "</td>";
                    echo "<td style='text-align:center'>" . $movie['rating'] . "</td>";
                    echo "<td style='text-align:center'>" . $movie['production'] . "</td>";
                    echo "<td style='text-align:center'>" . $movie['budget'] . "</td>";
                    echo "</tr>";
                }

                echo "</table>";
            } catch(PDOException $e) {
                echo "Error: " . $e->getMessage();
            } finally {
                // Close the database connection
                $conn = null;
            }
        }

        // Check if 'view_actors' query parameter is present
        if(isset($_GET['query']) && $_GET['query'] == 'view_actors') {
            try {
                // Connect to the database
                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
                // Prepare and execute the SQL query to select all actors
                $stmt = $conn->prepare("SELECT * FROM People");
                $stmt->execute();
        
                // Fetch all rows
                $actors = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
                // Display the actors
                echo "<h1>All Actors</h1>";
                echo "<table class='table table-md table-bordered'>";
                echo "<thead class='thead-dark' style='text-align: center'>";
                echo "<tr><th>ID</th><th>Name</th><th>Nationality</th><th>DOB</th><th>Gender</th></tr></thead>";
                
                foreach($actors as $actor) {
                    echo "<tr>";
                    echo "<td style='text-align:center'>" . $actor['id'] . "</td>";
                    echo "<td style='text-align:center'>" . $actor['name'] . "</td>";
                    echo "<td style='text-align:center'>" . $actor['nationality'] . "</td>";
                    echo "<td style='text-align:center'>" . $actor['dob'] . "</td>";
                    echo "<td style='text-align:center'>" . $actor['gender'] . "</td>";
                    echo "</tr>";
                }
        
                echo "</table>";
            } catch(PDOException $e) {
                echo "Error: " . $e->getMessage();
            } finally {
                // Close the database connection
                $conn = null;
            }
        }
        ?>
    </div>

</body>
</html>
