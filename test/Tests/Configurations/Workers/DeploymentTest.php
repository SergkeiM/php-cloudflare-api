<?php

namespace Cloudflare\Tests\Configurations\Workers;

use Cloudflare\Configurations\Workers\Deployment;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class DeploymentTest extends TestCase
{
    #[Test]
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

    #[Test]
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

    #[Test]
    public function shouldOverrideExistingVersion()
    {
        $deployment = (new Deployment('message'))
            ->addVersion('id', 0.2)
            ->addVersion('id', 0.5);

        $versions = $deployment->toArray()['versions'];

        $this->assertCount(1, $versions);
        $this->assertSame(0.5, $versions[0]['percentage']);
    }

    #[Test]
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
