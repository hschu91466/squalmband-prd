<?php
include_once '../includes/init.inc.php';
?>
<link rel="stylesheet" href="<?php echo $basePath . 'css/unsubscribe.css' ?>" />
<header id="header" class="main-banner">
    <?php
    include_once '../includes/nav.inc.php';
    ?>
</header>
<section class="unsubscribe-section section-container">
    <?php
    if (isset($_GET['email'])) {
        $email = urldecode($_GET['email']);

        if (isset($_POST['confirm'])) {
            // Remove email from the database
            $sql = "DELETE FROM signup WHERE signup_email = ?";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("s", $email);

            if ($stmt->execute()) {
                echo "<p>You have been unsubscribed successfully.</p>";
            } else {
                echo "<p>Error: " . $stmt->error . "</p>";
            }

            $stmt->close();
            $mysqli->close();
        } else {
            // Display confirmation message
            echo "<p>Are you sure you want to unsubscribe?</p>";
            echo "<form method='post'>";
            echo "<input type='hidden' name='email' value='" . htmlspecialchars($email) . "'>";
            echo "<button type='submit' name='confirm'>Yes, unsubscribe me</button>";
            echo "</form>";
        }
    } else {
        echo "<p>Invalid request.</p>";
    }
    ?>
</section>
<?php include_once '../includes/footer.inc.php'; ?>