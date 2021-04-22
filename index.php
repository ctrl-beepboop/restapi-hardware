<?php

define('BASE_PATH', dirname(__FILE__));

require BASE_PATH . '/vendor/autoload.php';

use App\APICall\POSTCall;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$request = parse_url($_SERVER['REQUEST_URI'])['path'];

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        $POSTCall = (new POSTCall())->callRequest($request);
        break;
}

