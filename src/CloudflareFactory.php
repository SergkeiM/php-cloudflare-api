<?php

namespace Cloudflare;

use Illuminate\Support\Arr;
use InvalidArgumentException;

class CloudflareFactory
{
    /**
     * Make a new github client.
     *
     * @param string[] $config
     *
     * @throws \InvalidArgumentException
     *
     * @return \Cloudflare\Client
     */
    public function make(array $config): Client
    {
        $client = new Client(Arr::get($config, 'token'));

        return $client;
    }
}
