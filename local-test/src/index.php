<?php

require __DIR__.'/../vendor/autoload.php';

use Dotenv\Dotenv;
use CloudFlare\Client;
use CloudFlare\Configurations\Zones\CachePurge;

$dotenv = Dotenv::createUnsafeMutable(__DIR__.'/../');
$dotenv->load();

$cachePurge = new CachePurge();

$cachePurge->everything()->byFiles(['myurl'])->byFilesAdvanced(
    'myurl', 'Desktop', 'GB'
)->byFilesAdvanced(
    'myurl2', 'Desktop', 'GB'
);

file_put_contents('./test.json', json_encode($cachePurge->toArray(), JSON_PRETTY_PRINT));

// $client = new Client(getenv('CLOUDFLARE_TOKEN'));

// $contents = file_get_contents('./test.txt');

// $response = $client->zones()->dns()->import(getenv('ZONE_ID'), $contents, true);

// //file_put_contents('./test.txt', $response->body());

// file_put_contents('./test.json', json_encode($response->json(), JSON_PRETTY_PRINT));
