<?php

require __DIR__.'/../vendor/autoload.php';

use Dotenv\Dotenv;
use CloudFlare\Client;
use CloudFlare\Configurations\PageRule;

$dotenv = Dotenv::createUnsafeMutable(__DIR__.'/../');
$dotenv->load();

$pageRule = new PageRule('example.com/*');

$pageRule
    ->setStatus(false)
    ->setPriority(100)
    ->disablePerformance(true)
    ->disableZaraz(true)
    ->disableZaraz(false)
    ->waf(true);

file_put_contents('./test.json', json_encode($pageRule->toArray(), JSON_PRETTY_PRINT));

// $client = new Client(getenv('CLOUDFLARE_TOKEN'));

// $contents = file_get_contents('./test.txt');

// $response = $client->zones()->dns()->import(getenv('ZONE_ID'), $contents, true);

// //file_put_contents('./test.txt', $response->body());

// file_put_contents('./test.json', json_encode($response->json(), JSON_PRETTY_PRINT));
