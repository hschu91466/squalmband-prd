<?php

$hostKey = strtoupper(str_replace(['.', ':'], ['_', '_'], $_SERVER['HTTP_HOST']));
$envKey = "BASE_URL_" . $hostKey;

$path = $_ENV[$envKey] ?? null;

if (!$path) {
    $path = 'Houston, we have a problem!';
}
