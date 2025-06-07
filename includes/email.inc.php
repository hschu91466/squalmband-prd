<?php
//Set to 0 for Prd, Change 0 to (1,1, E_ALL) for testing
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
ob_start();

require_once __DIR__ . '\init.inc.php';

function generateToken()
{
    return bin2hex(random_bytes(16));
}

// require 'includes/paths.inc.php';
// require 'includes/dbh.inc.php';

// // Load Composer's autoloader
// require 'vendor/autoload.php';

// Load environment variables from .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Determine environment
$env = $_ENV['APP_ENV'] ?? 'production';

// Select appropriate reCAPTCHA secret key
$recaptchaSecret = $env === 'development'
    ? $_ENV['RECAPTCHA_SECRET_KEY_DEV']
    : $_ENV['RECAPTCHA_SECRET_KEY_PROD'];

// Get reCAPTCHA response from form
$recaptchaResponse = $_POST['g-recaptcha-response'] ?? '';

// Validate reCAPTCHA
$verify = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$recaptchaSecret}&response={$recaptchaResponse}");
$responseData = json_decode($verify);

// Handle failure
if (!$responseData || !$responseData->success) {
    exit("reCAPTCHA verification failed.");
}

$fname = $_POST["fname"];
$lname = $_POST["lname"];
$email = $_POST["email"];
$signup = isset($_POST["signup"]) ? $_POST["signup"] : null; // Check if 'signup' key exists
$token = generateToken();
$confirmed = 0;
$signupText = "";
$subject = $_POST["subject"];
$message = $_POST["message"];

// Honeypot field check
if (!empty($_POST["address"])) {
    exit("Spam detected");
}

if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
    exit("Invalid email format");
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


$mail = new PHPMailer(true);
$mail->SMTPDebug = 0;
$mail->isSMTP();
$mail->isHTML(true);
$mail->SMTPAuth = true;
$mail->Host = "smtp.titan.email";
$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
$mail->Port = $_ENV['SMTP_PORT'];
$mail->Username = $_ENV['SMTP_USERNAME'];
$mail->Password = $_ENV['SMTP_PASSWORD'];
$mail->setFrom($_ENV['FROM_EMAIL'], $_ENV['FROM_NAME']);

$headers = "From: no-reply@squalmband.com";

$confirmationLink = "https://squalmband.com/pages/confirm.php?token=" . $token;
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


if ($signup) {
    // Confirmation email content
    $confirmationMessage = "Hello $fname,<br><br>Thank you for signing up for our newsletter!<br>Please confirm your email address by clicking the link: " . $confirmationLink . "<br><br>Best regards,<br>Squalm";
    $signupText = "<br> Subscribed to newsletter.";
    $confirmationMessage .= $social_links;
    $unsubscribeLink = "<hr>This email was sent to you because you signed up on our website. If you no longer wish to receive such emails, please <a href='https://squalmband.com/pages/unsubscribe.php?email=" . $email . "'>Unsubscribe</a>.";

    // Send confirmation email to the user
    $confirmationSubject = "Confirmation from the Squalm Website";
    $mail->clearAddresses(); // Clear previous addresses
    $mail->addAddress($email, "$fname $lname"); // Add user's email address
    $mail->addBCC("holly.schu14@gmail.com", "Postmaster at Squalmband (Confirmation)");
    $mail->Subject = $confirmationSubject;
    $mail->Body = $confirmationMessage;

    try {
        $mail->send();
        echo "Confirmation email has been sent.";
    } catch (Exception $e) {
        echo "Confirmation email could not be sent. Mailer Error: {$mail->ErrorInfo}";
        file_put_contents('email_errors.log', $mail->ErrorInfo, FILE_APPEND);
    }

    // Database insert/update
    $mysqli = mysqli_connect($dbServername, $dbUserName, $dbPassword, $dbName);
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    $sql = "SELECT * FROM signup WHERE signup_email = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Update token and set confirmed to 0 again
        $sql = "UPDATE signup SET token = ?, confirmed = 0 WHERE signup_email = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("ss", $token, $email);
        $stmt->execute();
        echo "Confirmation email re-sent.";
    } else {
        $sql = "INSERT INTO signup (signup_email, signup_fname, signup_lname, signup_time, token, confirmed) VALUES (?,?,?, NOW(),?,?)";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("ssssi", $email, $fname, $lname, $token, $confirmed);

        if ($stmt->execute()) {
            echo "Signup successful!";
        } else {
            echo "Error: " . $stmt->error;
        }
    }

    $stmt->close();
    $mysqli->close();

    $sentMsg = "Thank you for signing up for our newsletter!\nTo complete your subscription, please confirm your email address by clicking the link in the email we just sent you.";
} else {
    $confirmationMessage = "Hello $fname,<br><br>Thank you for getting in touch with us!<br><br>Best regards,<br>Squalm";
    $signupText = "<br> Not subscribed to newsletter.";
    $unsubscribeLink = "";
    $sentMsg = "Thank you for contacting squalm";
}


// Send notification email to you
$mail->clearAddresses(); // Clear previous addresses
$mail->addAddress("josiah@squalmband.com", "Josiah");
$mail->addAddress("postmaster@squalmband.com", "Postmaster at Squalmband");
$mail->Subject = "Message from Squalmband site.";
$mail->Body = "<br> Message from: " . $fname  . " " . $lname . "<br> Email Address: " . $email . "<br> Subject: " . $subject . "<br> Message: " . $message . $signupText;

try {
    $mail->send();
    echo "Notification email sent";
} catch (Exception $e) {
    echo "Notification email could not be sent. Mailer Error: {$mail->ErrorInfo}";
    file_put_contents('email_errors.log', $mail->ErrorInfo, FILE_APPEND);
}

// Convert newlines to <br> tags
$sentMsg = nl2br(htmlspecialchars($sentMsg));

// header("Location: " . $path . "/pages/sent.php");
header("Location: " . $path . "/pages/sent.php?message=" . urlencode($sentMsg));
exit();

ob_end_flush();
