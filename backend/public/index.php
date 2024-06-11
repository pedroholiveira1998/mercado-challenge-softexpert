<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

require_once '../vendor/autoload.php';
require_once '../src/utils/functions.php';
require_once '../config/dotenv.php';

require_once __DIR__ . '/../src/Routes/include.php';
