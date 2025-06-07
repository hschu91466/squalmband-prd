<?php

$hostKey = strtoupper(str_replace(['.', ':'], ['_', '_'], $_SERVER['HTTP_HOST']));
$envKey = "BASE_URL_" . $hostKey;

$basePath = $_ENV[$envKey] ?? '/ Sites / production / squalmband - prd /';
$imgPath = rtrim($basePath, '/') . '/img/';


// if (!$basePath) {
//     $basePath = '/Sites/production/squalmband-prd/';
// }
