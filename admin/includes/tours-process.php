<?php
require_once __DIR__ . '/../../includes/init.inc.php';

// session_start();

$id = 0;
$update = false;
$showForm = false;
$tourdate = '';
$tour_time = '';
$venue = '';
$location = '';

//Show Form (Add Music button)

if (isset($_GET['add'])) {
    $id = $_GET['add'];
    $showForm = true;
}

// check if button has been pressed
if (isset($_POST['save'])) {

    // $tourdate = $_POST['tourdate'];
    $tour_time = $_POST['tour_time'];
    $venue = $_POST['venue'];
    $location = $_POST['location'];

    echo $tourdate . " & " . date("y-m-d h:i A", strtotime($tour_time));

    $formatTourTime =
        date("y-m-d h:i:s A", strtotime($tour_time));

    if ($tour_time != "") {

        // echo $_SERVER;

        $sql = "INSERT INTO tour (tour_time,venue,location) 
        VALUES ('$tour_time', '$venue', '$location');";

        $_SESSION['message'] = "Record has been saved!";
        $_SESSION['msg_type'] = "success";

        if (mysqli_query($mysqli, $sql)) {
            header("location: " . $path . "admin/tourdates.php");
        }
    }
}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    // $tourdate = $_POST['tourdate'];
    $tour_time = $_POST['tour_time'];
    $venue = $_POST['venue'];
    $location = $_POST['location'];

    // $mysqli->query("UPDATE tour SET tourdate='$tourdate', venue='$venue', location='$location' where vid=$id") or die(mysqli_error($mysqli));
    $mysqli->query("UPDATE tour SET tour_time='$tour_time', venue='$venue', location='$location' where tid=$id") or die(mysqli_error($mysqli));



    $_SESSION['message'] = "Record has been updated!";
    $_SESSION['msg_type'] = "warning";

    header("location: " . $path . "admin/tourdates.php");
}

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $update = true;
    $result = $mysqli->query("SELECT * FROM tour where tid=$id") or die(mysqli_error($mysqli));

    $row = $result->fetch_array();

    // $tourdate = $row['tourdate'];
    $tour_time = $row['tour_time'];
    $venue = $row['venue'];
    $location = $row['location'];
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $mysqli->query("DELETE FROM tour where tid=$id") or die(mysqli_error($mysqli));

    $_SESSION['message'] = "Record has been deleted!";
    $_SESSION['msg_type'] = "danger";
}
