<?php

$hosts = [
    '127.0.0.1:8080' => 'http://127.0.0.1:8080/Sites/production/squalmband-prd/',
    '192.168.0.105:81' => 'http://192.168.0.105:81/sites/production/squalmband-prd/',
    '127.0.0.1:81' => 'http://127.0.0.1:81/Sites/production/squalmband-prd/',
    'squalmband.com' => 'https://squalmband.com/'
];

$path = $hosts[$_SERVER['HTTP_HOST']] ?? null;

if ($path === null) {
    $path = 'Houston, we have a problem!';
}
