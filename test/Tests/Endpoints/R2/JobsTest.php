<?php

namespace Cloudflare\Tests\Endpoints\R2;

use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

class JobsTest extends TestCase
{
    use InteractsWithMockClient;

    #[Test]
    public function shouldListJobs()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    ['id' => 'job_id', 'status' => 'RUNNING'],
                ],
            ])),
        ]);

        $response = $client->r2()->jobs()->list('account_id', 'my-bucket', [
            'jobType' => 'prefixDelete',
            'status' => 'RUNNING',
        ]);

        $this->assertTrue($response->successful());
        $this->assertSame('job_id', $response->json('result.0.id'));

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/r2/buckets/my-bucket/jobs', $this->lastRequest()->getUri()->getPath());
        $this->assertSame('jobType=prefixDelete&status=RUNNING', $this->lastRequest()->getUri()->getQuery());
    }

    #[Test]
    public function shouldGetJob()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => ['id' => 'job_id', 'status' => 'COMPLETED'],
            ])),
        ]);

        $response = $client->r2()->jobs()->get('account_id', 'my-bucket', 'job_id');

        $this->assertTrue($response->successful());
        $this->assertSame('COMPLETED', $response->json('result.status'));

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/r2/buckets/my-bucket/jobs/job_id', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldGetJobWithJurisdictionHeader()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => []])),
        ]);

        $client->r2()->jobs()->get('account_id', 'my-bucket', 'job_id', 'eu');

        $this->assertSame('eu', $this->lastRequest()->getHeaderLine('cf-r2-jurisdiction'));
    }
}
