<?php

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(dirname(__DIR__), ".env");
$dotenv->load();

return [
    "driver" => "oci8",
    "user" => $_ENV["DB_USERNAME"],
    "password" => $_ENV["DB_PASSWORD"],
    "dbname" => $_ENV["DB_DNS"],
];
