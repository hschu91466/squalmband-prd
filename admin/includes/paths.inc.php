<?php

switch ($_SERVER['HTTP_HOST']) {
    case '127.0.0.1:8080':
        $path = 'http://127.0.0.1:8080/Sites/squalm-prod/';
        $doc_path = $_SERVER["DOCUMENT_ROOT"] . "/img/";
        $vendor_path = $_SERVER["DOCUMENT_ROOT"]  . "/vendor/";
        break;
    case '127.0.0.1:81':
        $path = 'http://127.0.0.1:81/Sites/production/squalmband-prd/';
        $doc_path = $_SERVER["DOCUMENT_ROOT"] . "/img/";
        $vendor_path = $_SERVER["DOCUMENT_ROOT"] . "/vendor/";
        break;
    case 'squalmband.com':
        $path = 'https://squalmband.com/';
        $doc_path = $_SERVER["DOCUMENT_ROOT"] . "/img/";
        $vendor_path = $_SERVER["DOCUMENT_ROOT"] . "/vendor/";
        break;
}
