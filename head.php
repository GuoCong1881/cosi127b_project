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
?>