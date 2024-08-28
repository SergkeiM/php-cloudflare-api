<?php

namespace Cloudflare\Configurations\LoadBalancers;

use Cloudflare\Contracts\Configuration;

class LoadBalancer implements Configuration
{
    /**
     * Extends zero-downtime failover of requests to healthy origins from alternate pools, when no healthy alternate exists in the same pool, according to the failover order defined by traffic and origin steering. When set false (the default) zero-downtime failover will only occur between origins within the same pool. See `session_affinity_attributes` for control over when sessions are broken or reassigned.
     * @var bool
     */
    private bool $failoverAcrossPools = false;

    /**
     * Whether the hostname should be gray clouded (false) or orange clouded (true).
     * @var bool
     */
    private bool $proxied = false;

    /**
     * A mapping of country codes to a list of pool IDs (ordered by their failover priority) for the given country. Any country not explicitly defined will fall back to using the corresponding region_pool mapping if it exists else to default_pools.
     * @var array
     */
    private array $countryPools = [];

    /**
     * (Enterprise only): A mapping of Cloudflare PoP identifiers to a list of pool IDs (ordered by their failover priority) for the PoP (datacenter). Any PoPs not explicitly defined will fall back to using the corresponding country_pool, then region_pool mapping if it exists else to default_pools.
     * @var array
     */
    private array $popPools = [];

    /**
     * A mapping of region codes to a list of pool IDs (ordered by their failover priority) for the given region. Any regions not explicitly defined will fall back to using default_pools.
     * @var array
     */
    private array $regionPools = [];

    /**
     * Configures pool weights.
     * @var array
     */
    private array $randomSteering = [];

    /**
     * Object description.
     * @var string
     */
    private string $description = '';

    /**
     * Controls location-based steering for non-proxied requests. See steering_policy to learn how steering is affected.
     * @var array
     */
    private array $locationStrategy = [
        'mode' => 'pop',
        'prefer_ecs' => 'proximity'
    ];

    /**
     * Specifies the type of session affinity the load balancer should use unless specified as "none" or "" (default).
     * @var string
     */
    private string $sessionAffinity = 'none';

    /**
     * Steering Policy for this load balancer.
     * @var string
     */
    private string $steeringPolicy = '';

    /**
     * Time to live (TTL) of the DNS entry for the IP address returned by this load balancer. This only applies to gray-clouded (unproxied) load balancers.
     * @var int|null
     */
    private int|null $ttl = null;

    /**
     * @param string $name The DNS hostname to associate with your Load Balancer. If this hostname already exists as a DNS record in Cloudflare's DNS, the Load Balancer will take precedence and the DNS record will not be used.
     * @param string $fallbackPool The pool ID to use when all other pools are detected as unhealthy.
     * @param array $defaultPools A list of pool IDs ordered by their failover priority. Pools defined here are used by default, or when region_pools are not configured for a given region.
     */
    public function __construct(
        private string $name,
        private string $fallbackPool,
        private array $defaultPools
    ){

    }

    /**
     * Whether the hostname should be gray clouded (false) or orange clouded (true).
     * @param bool $proxied
     * @return \Cloudflare\Configurations\LoadBalancers\LoadBalancer
     */
    public function isProxied(bool $proxied): self
    {
        $this->proxied = $proxied;

        return $this;
    }

    /**
     * Extends zero-downtime failover of requests to healthy origins from alternate pools, when no healthy alternate exists in the same pool, according to the failover order defined by traffic and origin steering. When set false (the default) zero-downtime failover will only occur between origins within the same pool. See `session_affinity_attributes` for control over when sessions are broken or reassigned.
     * @param bool $failoverAcrossPools
     * @return \Cloudflare\Configurations\LoadBalancers\LoadBalancer
     */
    public function isFailoverAcrossPools(bool $failoverAcrossPools): self
    {
        $this->failoverAcrossPools = $failoverAcrossPools;

        return $this;
    }

    /**
     * Sets a mapping of country codes to a list of pool IDs (ordered by their failover priority) for the given country. Any country not explicitly defined will fall back to using the corresponding region_pool mapping if it exists else to default_pools.
     * @param array $pools
     * @return \Cloudflare\Configurations\LoadBalancers\LoadBalancer
     */
    public function setCountryPools(array $pools): self
    {
        $this->countryPools = $pools;

        return $this;
    }

    /**
     * (Enterprise only): A mapping of Cloudflare PoP identifiers to a list of pool IDs (ordered by their failover priority) for the PoP (datacenter). Any PoPs not explicitly defined will fall back to using the corresponding country_pool, then region_pool mapping if it exists else to default_pools.
     * @param array $pools
     * @return \Cloudflare\Configurations\LoadBalancers\LoadBalancer
     */
    public function setPopPools(array $pools): self
    {
        $this->popPools = $pools;

        return $this;
    }

    /**
     * A mapping of region codes to a list of pool IDs (ordered by their failover priority) for the given region. Any regions not explicitly defined will fall back to using default_pools.
     * @param array $pools
     * @return \Cloudflare\Configurations\LoadBalancers\LoadBalancer
     */
    public function setRegionPools(array $pools): self
    {
        $this->regionPools = $pools;

        return $this;
    }

    /**
     * Object description.
     * @param string $description
     * @return \Cloudflare\Configurations\LoadBalancers\LoadBalancer
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Controls location-based steering for non-proxied requests. See steering_policy to learn how steering is affected.
     * @param string $mode Determines the authoritative location when ECS is not preferred, does not exist in the request, or its GeoIP lookup is unsuccessful. `pop`, `resolver_ip`
     * @param string $preferEcs Whether the EDNS Client Subnet (ECS) GeoIP should be preferred as the authoritative location. 'always`, `never`, `proximity`, `geo`
     * @return \Cloudflare\Configurations\LoadBalancers\LoadBalancer
     */
    public function setLocationStrategy(string $mode, string $preferEcs): self
    {
        $this->locationStrategy = [
            'mode' => $mode,
            'prefer_ecs' => $preferEcs
        ];

        return $this;
    }

    /**
     * Configures pool weights.
     * @param int|float $defaultWeight The default weight for pools in the load balancer that are not specified in the pool_weights map.
     * @param array $poolWeights A mapping of pool IDs to custom weights. The weight is relative to other pools in the load balancer.
     * @return \Cloudflare\Configurations\LoadBalancers\LoadBalancer
     */
    public function setRandomSteering(int|float $defaultWeight = 1, array $poolWeights): self
    {
        $this->randomSteering = [
            'default_weight' => $defaultWeight,
            'pool_weights' => $poolWeights
        ];

        return $this;
    }

    /**
     * Specifies the type of session affinity the load balancer should use unless specified as "none" or "" (default). The supported types are:
     * - `cookie`: On the first request to a proxied load balancer, a cookie is generated, encoding information of which origin the request will be forwarded to. Subsequent requests, by the same client to the same load balancer, will be sent to the origin server the cookie encodes, for the duration of the cookie and as long as the origin server remains healthy.If the cookie has expired or the origin server is unhealthy, then a new origin server is calculated and used.
     * - `ip_cookie`: Behaves the same as "cookie" except the initial origin selection is stable and based on the client's ip address.
     * - `header`: On the first request to a proxied load balancer, a session key based on the configured HTTP headers (see session_affinity_attributes.headers) is generated, encoding the request headers used for storing in the load balancer session state which origin the request will be forwarded to. Subsequent requests to the load balancer with the same headers will be sent to the same origin server, for the duration of the session and as long as the origin server remains healthy. If the session has been idle for the duration of session_affinity_ttl seconds or the origin server is unhealthy, then a new origin server is calculated and used. See headers in session_affinity_attributes for additional required configuration.
     * @param string $sessionAffinity
     * @return \Cloudflare\Configurations\LoadBalancers\LoadBalancer
     */
    public function setSessionAffinity(string $sessionAffinity): self
    {
        $this->sessionAffinity = $sessionAffinity;

        return $this;
    }

    /**
     * Steering Policy for this load balancer.
     * - `off`: Use default_pools.
     * - `geo`: Use region_pools/country_pools/pop_pools. For non-proxied requests, the country for country_pools is determined by location_strategy.
     * - `random`: Select a pool randomly.
     * - `dynamic_latency`: Use round trip time to select the closest pool in default_pools (requires pool health checks).
     * - `proximity`: Use the pools' latitude and longitude to select the closest pool using the Cloudflare PoP location for proxied requests or the location determined by location_strategy for non-proxied requests.
     * - `least_outstanding_requests`: Select a pool by taking into consideration random_steering weights, as well as each pool's number of outstanding requests. Pools with more pending requests are weighted proportionately less relative to others.
     * - `least_connections`: Select a pool by taking into consideration random_steering weights, as well as each pool's number of open connections. Pools with more open connections are weighted proportionately less relative to others. Supported for HTTP/1 and HTTP/2 connections.
     * - `""`: Will map to `geo` if you use region_pools/country_pools/pop_pools otherwise `off`.
     * @param string $steeringPolicy
     * @return \Cloudflare\Configurations\LoadBalancers\LoadBalancer
     */
    public function setSteeringPolicy(string $steeringPolicy): self
    {
        $this->steeringPolicy = $steeringPolicy;

        return $this;
    }

    /**
     * Time to live (TTL) of the DNS entry for the IP address returned by this load balancer. This only applies to gray-clouded (unproxied) load balancers.
     * @param int $ttl
     * @return \Cloudflare\Configurations\LoadBalancers\LoadBalancer
     */
    public function setTtl(int $ttl): self
    {
        $this->ttl = $ttl;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'adaptive_routing' => [
                'failover_across_pools' => $this->failoverAcrossPools
            ],
            'country_pools' => $this->countryPools,
            'default_pools' => $this->defaultPools,
            'description' => $this->description,
            'fallback_pool' => $this->fallbackPool,
            'location_strategy' => $this->locationStrategy,
            'pop_pools' => $this->popPools,
            'proxied' => $this->proxied,
            'random_steering' => $this->randomSteering,
            'region_pools' => $this->regionPools
        ];
    }
}