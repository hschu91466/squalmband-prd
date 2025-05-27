<?php

// echo '<pre>';
// print_r($_ENV);
// echo '</pre>';
// exit;


// Load Composer's autoloader
require_once __DIR__ . '/../vendor/autoload.php';

// Load environment variables from .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();


// Setup Recaptcha
$isLocalhost = in_array($_SERVER['SERVER_NAME'], ['localhost', '127.0.0.1']);

$recaptchaSiteKey = $isLocalhost ? $_ENV['RECAPTCHA_SITE_KEY_DEV'] : $_ENV['RECAPTCHA_SITE_KEY_PROD'];
$recaptchaSecretKey = $isLocalhost ? $_ENV['RECAPTCHA_SECRET_KEY_DEV'] : $_ENV['RECAPTCHA_SECRET_KEY_PROD'];


// Project Files

include_once __DIR__ . DIRECTORY_SEPARATOR . 'dbh.inc.php'; // Ensure this is included first
include_once __DIR__ . DIRECTORY_SEPARATOR . 'paths.inc.php';
include_once __DIR__ . DIRECTORY_SEPARATOR . 'header.inc.php';
include_once __DIR__ . DIRECTORY_SEPARATOR . 'queries.inc.php';
