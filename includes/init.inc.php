<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Load Composer's autoloader
require_once __DIR__ . '/../vendor/autoload.php';

// Load environment variables from .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

if (!isset($_ENV['DB_HOST'])) {
    die('Environment variables not loaded. Check your .env file and path.');
}

// Setup Recaptcha
$isLocalhost = in_array($_SERVER['SERVER_NAME'], ['localhost', '127.0.0.1']);

$recaptchaSiteKey = $isLocalhost ? $_ENV['RECAPTCHA_SITE_KEY_DEV'] : $_ENV['RECAPTCHA_SITE_KEY_PROD'];
$recaptchaSecretKey = $isLocalhost ? $_ENV['RECAPTCHA_SECRET_KEY_DEV'] : $_ENV['RECAPTCHA_SECRET_KEY_PROD'];

// Project Files
require_once __DIR__ . DIRECTORY_SEPARATOR . 'dbh.inc.php'; // Ensure this is included first
require_once __DIR__ . DIRECTORY_SEPARATOR . 'paths.inc.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'queries.inc.php';


// Include the correct header based on path
$scriptPath = str_replace('\\', '/', $_SERVER['SCRIPT_FILENAME']); // Normalize slashes for Windows
if (strpos($scriptPath, '/admin/') !== false) {
    require_once __DIR__ . '/../admin/includes/header-admin.inc.php';
} else {
    require_once __DIR__ . '/header.inc.php';
}
