<?php
// Connect to the database
$conn = mysqli_connect("localhost", "username", "password", "database_name");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Define the query to fetch actors with their full names
$sql = "SELECT p.id, CONCAT(p.name, ' (', n.nationality, ')') AS full_name
        FROM People p
        INNER JOIN Nationality n ON p.nationality = n.code";

// Execute the query
$result = mysqli_query($conn, $sql);

// Check for errors
if (!$result) {
    die("Error getting actors: " . mysqli_error($conn));
}

// Build the table content
$table = "<table>
  <tr>
    <th>ID</th>
    <th>Name</th>
  </tr>";

while ($row = mysqli_fetch_assoc($result)) {
    $table .= "<tr>
      <td>" . $row["id"] . "</td>
      <td>" . $row["full_name"] . "</td>
    </tr>";
}

$table .= "</table>";

// Close connection
mysqli_close($conn);

echo $table;