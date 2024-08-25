<?php

require __DIR__.'/../vendor/autoload.php';

use Dotenv\Dotenv;
use Cloudflare\Client;
use Cloudflare\ExpressionBuilder;
use Cloudflare\Configurations\Rules\BlockRule;
use Cloudflare\Configurations\Zones\CachePurge;

$dotenv = Dotenv::createUnsafeMutable(__DIR__.'/../');
$dotenv->load();

$blockRule = new BlockRule(['sss']);

$blockRule->setExpression(function(ExpressionBuilder $builder){
    return $builder->field('ip.src')->eq('192.168.1.2')->or()->group(function(ExpressionBuilder $bilder){
        $bilder->not()->field('ssl')->or()->field('udp')->contains(32);
    })->or()->addExpression('ip.src', 'eq', '127.0.01');
});

var_dump($blockRule->toArray());

// $cachePurge = new CachePurge();

// $cachePurge->everything()->byFiles(['myurl'])->byFilesAdvanced(
//     'myurl', 'Desktop', 'GB'
// )->byFilesAdvanced(
//     'myurl2', 'Desktop', 'GB'
// );

// file_put_contents('./test.json', json_encode($cachePurge->toArray(), JSON_PRETTY_PRINT));

// $client = new Client(getenv('CLOUDFLARE_TOKEN'));

// $contents = file_get_contents('./test.txt');

// $response = $client->zones()->dns()->import(getenv('ZONE_ID'), $contents, true);

// //file_put_contents('./test.txt', $response->body());

// file_put_contents('./test.json', json_encode($response->json(), JSON_PRETTY_PRINT));
