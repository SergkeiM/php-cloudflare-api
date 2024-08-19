<?php

namespace Cloudflare\Tests\Configurations\Workers;

use Cloudflare\Configurations\Workers\Deployment;

class DeploymentTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @test
     */
    public function shouldNotHaveVersions()
    {
        $deployment = new Deployment('This is a human-readable message about the deployment');

        $this->assertEquals([
            'strategy' => 'percentage',
            'annotations' => [
                'workers/message' => 'This is a human-readable message about the deployment',
            ],
            'versions' => []
        ], $deployment->toArray());
    }

    public function shouldHaveVersions()
    {
        $deployment = new Deployment('This is a human-readable message about the deployment');

        $deployment->addVersion('id', 0.2);

        $this->assertEquals([
            'strategy' => 'percentage',
            'annotations' => [
                'workers/message' => 'This is a human-readable message about the deployment',
            ],
            'versions' => [
                [
                    'version_id' => 'id',
                    'percentage' => 0.2
                ]
            ]
        ], $deployment->toArray());
    }

    public function shouldUpdateMessage()
    {
        $deployment = new Deployment('This is a human-readable message about the deployment');

        $deployment->setMessage('Message Changed');

        $this->assertEquals([
            'strategy' => 'percentage',
            'annotations' => [
                'workers/message' => 'Message Changed',
            ],
            'versions' => []
        ], $deployment->toArray());
    }
}
