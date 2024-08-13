<?php

require __DIR__.'/../vendor/autoload.php';

use Dotenv\Dotenv;
use SergkeiM\CloudFlare\Client;
use SergkeiM\CloudFlare\Exceptions\RequestException;

$dotenv = Dotenv::createUnsafeMutable(__DIR__.'/../');
$dotenv->load();

$client = new Client(getenv('CLOUDFLARE_TOKEN'));

$response = $client->zones()->dns()->export(getenv('ZONE_ID'));

file_put_contents('./test.txt', $response->body());

$file = file_get_contents('./test.txt', true);

try {

    $response = $client->zones()->dns()->import(getenv('ZONE_ID'), $file);

} catch (RequestException $th) {
    
    var_dump($th->getResponse()->toArray());
}
