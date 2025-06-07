<?php
include_once '../includes/init.inc.php';

// Start output buffering
ob_start();

//token verification and confirmation logic
$token = $_GET['token'];

$stmt = $mysqli->prepare("SELECT signup_email FROM signup WHERE token = ? AND confirmed = 0");
$stmt->bind_param("s", $token);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->close();

    $stmt = $mysqli->prepare("UPDATE signup SET confirmed = 1 WHERE token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $message = "Email confirmed! Thank you for subscribing.";
} else {
    $message = "Invalid or expired token.";
}

$stmt->close();
$mysqli->close();

// Set the header for redirection
header("refresh:3;url=" . $path);

// End output buffering and flush output
ob_end_flush();
?>

<link rel="stylesheet" href="<?php echo $path . 'css/unsubscribe.css' ?>" />
<header id="header" class="main-banner">
    <?php include_once '../includes/nav.inc.php'; ?>
</header>
<section class="email-sent section-container">
    <h1><?php echo $message; ?></h1>
    <p>You will be redirected in 3 seconds</p>
</section>
<?php include_once '../includes/footer.inc.php'; ?>