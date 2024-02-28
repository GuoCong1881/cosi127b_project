<?php
// Connect to the database
$conn = mysqli_connect("localhost", "username", "password", "database_name");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Define the query
$sql = "SELECT * FROM MotionPicture";

// Execute the query
$result = mysqli_query($conn, $sql);

// Check for errors
if (!$result) {
    die("Error getting movies: " . mysqli_error($conn));
}

// Build the table content
$table = "<table>
  <tr>
    <th>ID</th>
    <th>Name</th>
    <th>Rating</th>
    <th>Production</th>
    <th>Budget</th>
  </tr>";

while ($row = mysqli_fetch_assoc($result)) {
    $table .= "<tr>
      <td>" . $row["id"] . "</td>
      <td>" . $row["name"] . "</td>
      <td>" . $row["rating"] . "</td>
      <td>" . $row["production"] . "</td>
      <td>" . $row["budget"] . "</td>
    </tr>";
}

$table .= "</table>";

// Close connection
mysqli_close($conn);

echo $table;