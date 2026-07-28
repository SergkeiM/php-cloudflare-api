<?php

namespace Cloudflare\Tests\HttpClient\Exceptions;

use Cloudflare\HttpClient\Exceptions\RequestException;
use Cloudflare\HttpClient\Response;
use GuzzleHttp\Psr7\Response as PsrResponse;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class RequestExceptionTest extends TestCase
{
    #[Test]
    public function shouldIncludeBodySummaryInMessage()
    {
        $response = new Response(new PsrResponse(499, [], json_encode(['error' => 'something went wrong'])));

        $exception = new RequestException($response);

        $this->assertSame(499, $exception->getCode());
        $this->assertStringContainsString('HTTP request returned status code 499', $exception->getMessage());
        $this->assertStringContainsString('something went wrong', $exception->getMessage());
        $this->assertSame($response, $exception->response);
    }

    #[Test]
    public function shouldOmitBodySummaryWhenBodyIsEmpty()
    {
        $response = new Response(new PsrResponse(499, [], ''));

        $exception = new RequestException($response);

        $this->assertSame('HTTP request returned status code 499', $exception->getMessage());
    }
}
