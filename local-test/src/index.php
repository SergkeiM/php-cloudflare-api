<?php

require __DIR__.'/../vendor/autoload.php';

use Dotenv\Dotenv;
use SergkeiM\CloudFlare\Client;

$dotenv = Dotenv::createUnsafeMutable(__DIR__.'/../');
$dotenv->load();

$client = new Client(getenv('CLOUDFLARE_TOKEN'));

$response = $client->accounts()->all();

var_dump($response);
