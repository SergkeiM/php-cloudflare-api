<?php

namespace Cloudflare;

use GrahamCampbell\Manager\AbstractManager;
use Illuminate\Contracts\Config\Repository;

/**
 * This is the cloudflare manager class.
 *
 * @method \Cloudflare\Client                             connection(string|null $name = null)
 * @method \Cloudflare\Client                             reconnect(string|null $name = null)
 * @method void                                           disconnect(string|null $name = null)
 * @method array<string,\Cloudflare\Client>               getConnections()
 * @method \Cloudflare\Endpoints\Accounts                 accounts()
 * @method \Cloudflare\Endpoints\D1                       d1()
 * @method \Cloudflare\Endpoints\IP                       ips()
 * @method \Cloudflare\Endpoints\Zones                    zones()
 * @method \Cloudflare\Endpoints\Workers                  workers()
 * @method \Cloudflare\Endpoints\Tunnel                   tunnel()
 */
class CloudflareManager extends AbstractManager
{
    /**
     * The factory instance.
     *
     * @var \Cloudflare\CloudflareFactory
     */
    protected CloudflareFactory $factory;

    /**
     * Create a new github manager instance.
     *
     * @param \Illuminate\Contracts\Config\Repository $config
     * @param \Cloudflare\CloudflareFactory $factory
     *
     * @return void
     */
    public function __construct(Repository $config, CloudflareFactory $factory)
    {
        parent::__construct($config);
        $this->factory = $factory;
    }

    /**
     * Create the connection instance.
     *
     * @param array $config
     *
     * @return \Cloudflare\Client
     */
    protected function createConnection(array $config): Client
    {
        return $this->factory->make($config);
    }

    /**
     * Get the configuration name.
     *
     * @return string
     */
    protected function getConfigName(): string
    {
        return 'cloudflare';
    }

    /**
     * Get the configuration for a connection.
     *
     * @param string|null $name
     *
     * @throws \InvalidArgumentException
     *
     * @return array
     */
    public function getConnectionConfig(string $name = null): array
    {
        $config = parent::getConnectionConfig($name);

        return $config;
    }

    /**
     * Get the factory instance.
     *
     * @return \Cloudflare\CloudflareFactory
     */
    public function getFactory(): CloudflareFactory
    {
        return $this->factory;
    }
}
