<?php

// $dbServername = "62.72.50.204";
// $dbUserName = "u371076943_jozay";
// $dbPassword = "GJ-4getuman2";
// $dbName = "u371076943_jozay";

$dbServername = "62.72.50.204";
$dbUserName = "u371076943_jozaya";
$dbPassword = "GJ-4getuman2";
$dbName = "u371076943_jozaya";

// $conn = mysqli_connect($dbServername, $dbUserName, $dbPassword, $dbName);
// if ($conn->connect_error) {
//     die("Connection failed" . $conn->connect_error);
// };

$mysqli = mysqli_connect($dbServername, $dbUserName, $dbPassword, $dbName);
if ($mysqli->connect_error) {
    die("Connection failed" . $mysqli->connect_error);
};
