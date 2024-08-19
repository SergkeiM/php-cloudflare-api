<?php

namespace Cloudflare\Configurations\Workers;

use Cloudflare\Contracts\Configuration;

class Deployment implements Configuration
{
    /**
     * Strategy (Only percentage is available.)
     * @var string
     */
    private string $strategy = 'percentage';

    /**
     * Worker Versions
     * @var array
     */
    private array $versions = [];

    /**
     * @param string $message Human-readable message about the deployment.
     */
    public function __construct(private string $message)
    {

    }

    /**
     * Set deployment message
     * @param string $message Human-readable message about the deployment.
     * @return \Cloudflare\Configurations\Workers\Deployment
     */
    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Add Version.
     * @param string $version_id
     * @param float|int $percentage
     * @return \Cloudflare\Configurations\Workers\Deployment
     */
    public function addVersion(string $version_id, float|int $percentage = 100): self
    {
        $ids = array_column($this->versions, 'version_id');
        $index = array_search($version_id, $ids);

        $newValue = [
            'version_id' => $version_id,
            'percentage' => $percentage,
        ];

        if ($index !== false) {
            $this->versions[$index] = $newValue;
        } else {
            $this->versions[] = $newValue;
        }

        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $options = [
            'strategy' => $this->strategy,
            'annotations' => [
                'workers/message' => $this->message,
            ],
            'versions' => $this->versions
        ];

        return $options;
    }
}
