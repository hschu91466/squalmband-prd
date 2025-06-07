<?php
require_once __DIR__ . '/../../includes/init.inc.php';
include 'email_config.php';

if (isset($_POST['delete'])) {
    $email = $_POST['email'];

    $sql = "DELETE FROM signup WHERE signup_email=?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $email);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Subscriber deleted successfully!";
    } else {
        $_SESSION['message'] = "Error deleting subscriber.";
    }

    $stmt->close();
    $mysqli->close();

    header("Location: ../newsletter.php");
    exit();
}

$vendor_path = __DIR__ . '/../../vendor/autoload.php';

if (file_exists($vendor_path)) {
    require $vendor_path;
} else {
    $error_message = "Path is incorrect or file does not exist: " . $vendor_path;
    echo $error_message;
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

// session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $subject = htmlspecialchars($_POST['subject']);
    $content = htmlspecialchars($_POST['content']);

    // Fetch email addresses and first names from the signup table
    $sql_signup = "SELECT signup_email, signup_fname FROM signup where confirmed = 1";
    $result_signup = $mysqli->query($sql_signup);

    // Fetch tour dates and locations from the tour table
    $sql_tour = "SELECT tourdate, DATE_FORMAT(tour_time, '%M %d, %Y %r') AS formatted_tour_time, venue, location FROM tour where tour_time >= CURDATE()";
    $result_tour = $mysqli->query($sql_tour);

    $include_tour_dates = isset($_POST['include_tour_dates']) ? true : false;

    // Prepare tour dates content
    $tour_content = "<h2>Upcoming Tour Dates</h2><table style='width: 100%; border-collapse: collapse;'><thead><tr><th style='border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;'>Date/Time</th><th style='border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;'>Venue</th><th style='border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;'>Location</th></tr></thead><tbody>";

    if ($include_tour_dates) {
        if ($result_tour->num_rows > 0) {
            while ($row_tour = $result_tour->fetch_assoc()) {
                $tour_content .= "<tr><td style='border: 1px solid #ddd; padding: 8px;'>" . htmlspecialchars($row_tour['formatted_tour_time']) . "</td><td style='border: 1px solid #ddd; padding: 8px;'>" . htmlspecialchars($row_tour['venue']) . "</td><td style='border: 1px solid #ddd; padding: 8px;'>" . htmlspecialchars($row_tour['location']) . "</td></tr>";
            }
        } else {
            $tour_content .= "<tr><td colspan='4' style='border: 1px solid #ddd; padding: 8px;'>No tour dates available.</td></tr>";
        }
        $tour_content .= "</tbody></table><br><br>";
    } else {
        $tour_content = "";
    }




    // Social media links
    $social_links = "
    <p>Follow us on social media:</p>
    <p>
        <a href='https://www.facebook.com/profile.php?id=61551555816555&mibextid=ZbWKwL' target='_blank'>Facebook</a> |
        <a href='https://open.spotify.com/artist/2cMMWuinHbQs0Bf1RTVNgH?si=edduLr8cTeWX836mLhJjCA' target='_blank'>Spotify</a> |
        <a href='https://instagram.com/squalm2?igshid=OGQ5ZDc2ODk2ZA==' target='_blank'>Instagram</a> |
        <a href='https://x.com/Squalm1175841?t=zaONE7OqIAf8n9NFVbKSTQ&s=09' target='_blank'>Twitter</a> |
        <a href='https://www.snapchat.com/add/squalm_band?share_id=VylJjntB1DM&locale=en-US' target='_blank'>Snapchat</a> |
        <a href='https://music.apple.com/us/artist/squalm/1623436486' target='_blank'>Apple Music</a>
    </p>";

    if ($result_signup->num_rows > 0) {
        while ($row_signup = $result_signup->fetch_assoc()) {
            $mail = new PHPMailer(true);

            try {
                $mail->SMTPDebug = SMTP::DEBUG_OFF;
                $mail->isSMTP();
                $mail->SMTPAuth = true;
                $mail->Host = "smtp.titan.email";
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port = 465;
                $mail->Username = $pmUserName;
                $mail->Password = $pmPassword;
                // $mail->setFrom("postmaster@squalmband.com", "Postmaster at Squalmband");
                $mail->setFrom("postmaster@hollyschu.com", "Postmaster at Squalmband");
                $mail->addAddress($row_signup['signup_email']);
                $mail->addBCC("holly.schu14@gmail.com", "Postmaster at Squalmband (BCC)");
                $mail->Subject = $subject;

                $signup_fname = htmlspecialchars($row_signup['signup_fname']);
                $unsubscribeLink = "https://squalmband.com/pages/unsubscribe.php?email=" . urlencode($row_signup['signup_email']);
                $mail->Body = "
                <div style='font-family: Arial, sans-serif; padding: 20px'>
                <h1 style='color: #333'>SQUALM Newsletter</h1>
                <p>Hi $signup_fname,</p><br><br>$content $tour_content<br><br><p>
    Don't miss out on our latest news and updates. Follow us on social media!
  </p>
  <p>Best regards,<br />Squalm</p><br><br>$social_links<hr>This email was sent to you because you signed up on our website.  If you no longer wish to receive such emails, please <a href='$unsubscribeLink'>Unsubscribe</a>.
                </div>
                ";
                $mail->isHTML(true);

                $mail->send();
                $_SESSION['message'] = "Newsletter sent successfully!";
            } catch (Exception $e) {
                $error_message = "Newsletter could not be sent to " . htmlspecialchars($row_signup['signup_email']) . ". Mailer Error: {$mail->ErrorInfo}";
                echo $error_message;
                echo "<script>console.log('$error_message');</script>";
            }
        }
    } else {
        echo "No subscribers found.";
        echo "<script>console.log('No subscribers found.');</script>";
    }

    $mysqli->close();
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
} else {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        echo "Form not submitted correctly.";
        echo "<script>console.log('Form not submitted correctly.');</script>";
    }
}
