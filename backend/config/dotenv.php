<?php

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../../../app');
$dotenv->load();

$dotenv->required(['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASSWORD']);