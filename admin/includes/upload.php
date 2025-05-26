<?php
include_once "paths.inc.php";


if (isset($_POST['submit'])) {
    $file = $_FILES['file'];

    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    $fileType = $_FILES['file']['type'];



    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array('jpg', 'jpeg', 'png');

    if (in_array($fileActualExt, $allowed)) {
        if ($fileError === 0) {
            if ($fileSize < 15000000) {
                $fileNameNew = uniqid('', true) . "." . $fileActualExt;
                // $fileDestination = $path . 'img/' . $fileNameNew;
                $fileDestination = $doc_path . $fileNameNew;

                echo $path . 'img/' . $fileNameNew;
                move_uploaded_file($fileTmpName, $fileDestination);
                // header("location: " . $path . "admin/news.php?uploadsuccess");
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
