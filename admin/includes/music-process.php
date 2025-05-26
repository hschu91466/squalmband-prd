<?php
require 'dbh.inc.php';
require 'paths.inc.php';

session_start();

$id = 0;
$update = false;
$showForm = false;
$title = '';
$description = '';
$src = '';
$featured = '';
$cover = '';

//Show Form (Add Music button)

if (isset($_GET['add'])) {
    $id = $_GET['add'];
    $showForm = true;
}

// Add Music (Save button)
if (isset($_POST['save'])) {

    saveMusic($mysqli, $sql, $path);
}

function saveMusic($mysqli, $sql, $path)
{
    $title = str_replace("'", "&#039;", $_POST['title']);
    $description = $_POST['description'];
    $src = $_POST['src'];
    $featured = $_POST['featured'];
    $cover = $_POST['cover'];

    $sql = "INSERT INTO videos (title,description,src,featured,cover) 
        VALUES ('$title', '$description', '$src', '$featured', '$cover');";

    $_SESSION['message'] = "Record has been saved!";
    $_SESSION['msg_type'] = "success";

    if (mysqli_query($mysqli, $sql)) {
        header("location: " . $path . "admin/");
    }
}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $title = str_replace("'", "&#039;", $_POST['title']);
    $description = $_POST['description'];
    $src = $_POST['src'];
    $featured = $_POST['featured'];
    $cover = $_POST['cover'];

    // $mysqli->query("UPDATE videos SET title='$title', description='$description', src='$src', featured='$featured', cover='$cover' where vid=$id") or die(mysqli_error($mysqli));
    $mysqli->query("UPDATE videos SET title='$title', description='$description', src='$src', featured='$featured', cover='$cover' where vid=$id") or die(mysqli_error($mysqli));



    $_SESSION['message'] = "Record has been updated!";
    $_SESSION['msg_type'] = "warning";

    header("location: " . $path . "admin/");
}

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $update = true;
    $result = $mysqli->query("SELECT * FROM videos where vid=$id") or die(mysqli_error($mysqli));

    $row = $result->fetch_array();

    $title = $row['title'];
    $description = $row['description'];
    $src = $row['src'];
    $featured = $row['featured'];
    $cover = $row['cover'];
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $mysqli->query("DELETE FROM videos where vid=$id") or die(mysqli_error($mysqli));

    $_SESSION['message'] = "Record has been deleted!";
    $_SESSION['msg_type'] = "danger";
}
