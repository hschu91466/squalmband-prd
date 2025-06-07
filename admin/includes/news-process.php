<?php
require_once __DIR__ . '/../../includes/init.inc.php';

// session_start();

$id = 0;
$update = false;
$showForm = false;
$title = '';
$article = '';
$created_date = date("Y/m/d");
$img_path = '';
$section = '';
$media_type = '';

//Show Form (Add Music button)

if (isset($_GET['add'])) {
    $id = $_GET['add'];
    $showForm = true;
}

// check if button has been pressed
if (isset($_POST['save'])) {

    $title = str_replace("'", "&#039;", $_POST['title']);
    $article = str_replace("'", "&#039;", $_POST['article']);
    $created_date = date("Y/m/d");
    $img_path = $_POST['img_path'];
    $section = $_POST['section'];
    $media_type = $_POST['media_type'];

    $file = $_FILES['file'];

    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    $fileType = $_FILES['file']['type'];

    // Add new item process
    if ($title != "") {

        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));

        $allowed = array(
            'jpg',
            'jpeg',
            'png'
        );

        if (in_array($fileActualExt, $allowed)) {
            if ($fileError === 0) {
                if ($fileSize < 3000000) {
                    $fileNameNew = uniqid('', true) . "." . $fileActualExt;
                    $fileDestination = $doc_path . $fileNameNew;

                    echo $path . 'img/' . $fileNameNew;
                    move_uploaded_file($fileTmpName, $fileDestination);
                    ini_set("display_errors", "1");
                    ini_set('display_startup_errors', 1);
                    error_reporting(-1);
                    $img_path = $fileNameNew;
                    echo "WTF??";
                    $sql = "INSERT INTO news (title,article,created_date,img_path,section,media_type) 
        VALUES ('$title', '$article','$created_date', '$img_path', '$section', '$media_type');";



                    echo $sql;

                    $_SESSION['message'] = "Record has been saved!";
                    $_SESSION['msg_type'] = "success";

                    if (mysqli_query($mysqli, $sql)) {
                        header("location: " . $path . "admin/news.php");
                    }
                } else {
                    echo "Your file is too large!";
                }
            } else {
                echo "There was an error uploading your file!";
            }
        } else {
            echo "You cannot upload files of this type!";
        }
    }
}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $title = str_replace("'", "&#039;", $_POST['title']);
    $article = str_replace("'", "&#039;", $_POST['article']);
    $created_date = $_POST['created_date'];
    $img_path = $_POST['img_path'];
    $section = $_POST['section'];
    $media_type = $_POST['media_type'];

    $file = $_FILES['file'];

    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    $fileType = $_FILES['file']['type'];

    // Add new item process
    if ($title != "") {

        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));

        $allowed = array(
            'jpg',
            'jpeg',
            'png'
        );

        if (in_array($fileActualExt, $allowed)) {
            if ($fileError === 0) {
                if ($fileSize < 1000000) {
                    $fileNameNew = uniqid('', true) . "." . $fileActualExt;
                    $fileDestination = $doc_path . $fileNameNew;

                    echo $path . 'img/' . $fileNameNew;
                    move_uploaded_file($fileTmpName, $fileDestination);
                    $img_path = $fileNameNew;
                } else {
                    echo "Your file is too large!";
                }
            } else {
                echo "There was an error uploading your file!";
            }
        } else {
            echo "You cannot upload files of this type!";
        }
    }

    $mysqli->query("UPDATE news SET title='$title', article='$article', created_date='$created_date', img_path='$img_path', section='$section', media_type='$media_type' where nid=$id") or die(mysqli_error($mysqli));

    $_SESSION['message'] = "Record has been updated!";
    $_SESSION['msg_type'] = "warning";

    header("location: " . $path . "admin/news.php");
}

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $update = true;
    $result = $mysqli->query("SELECT * FROM news where nid=$id") or die(mysqli_error($mysqli));

    $row = $result->fetch_array();

    $title = $row['title'];
    $article = $row['article'];
    $created_date = $row['created_date'];
    $img_path = $row['img_path'];
    $section = $row['section'];
    $media_type = $row['media_type'];
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $mysqli->query("DELETE FROM news where nid=$id") or die(mysqli_error($mysqli));

    $_SESSION['message'] = "Record has been deleted!";
    $_SESSION['msg_type'] = "danger";
}
