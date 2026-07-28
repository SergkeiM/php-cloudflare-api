<?php

namespace Cloudflare\Tests\HttpClient;

use Cloudflare\HttpClient\Response;
use GuzzleHttp\Psr7\Response as PsrResponse;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class ResponseTest extends TestCase
{
    #[Test]
    public function shouldReturnBody()
    {
        $response = new Response(new PsrResponse(200, [], 'raw body'));

        $this->assertSame('raw body', $response->body());
    }

    #[Test]
    public function shouldReturnFullDecodedJsonWithoutKey()
    {
        $response = new Response(new PsrResponse(200, [], json_encode(['success' => true, 'result' => ['id' => 'x']])));

        $this->assertSame([
            'success' => true,
            'result' => ['id' => 'x'],
        ], $response->json());
    }

    #[Test]
    public function shouldReturnDefaultForMissingKey()
    {
        $response = new Response(new PsrResponse(200, [], json_encode(['result' => ['id' => 'x']])));

        $this->assertSame('fallback', $response->json('result.missing', 'fallback'));
    }

    #[Test]
    public function shouldReturnUnderlyingPsrResponse()
    {
        $psrResponse = new PsrResponse(200, [], 'body');

        $response = new Response($psrResponse);

        $this->assertSame($psrResponse, $response->toPsrResponse());
    }

    #[Test]
    public function shouldReturnStatus()
    {
        $response = new Response(new PsrResponse(201, [], ''));

        $this->assertSame(201, $response->status());
    }

    #[Test]
    public function shouldBeSuccessfulOnlyForStatus200()
    {
        $this->assertTrue((new Response(new PsrResponse(200, [], '')))->successful());
        $this->assertFalse((new Response(new PsrResponse(201, [], '')))->successful());
    }

    #[Test]
    public function shouldBeFailedForNon200Status()
    {
        $this->assertTrue((new Response(new PsrResponse(404, [], '')))->failed());
        $this->assertFalse((new Response(new PsrResponse(200, [], '')))->failed());
    }

    #[Test]
    public function shouldTraverseObjectTargets()
    {
        $response = new Response(new PsrResponse(200, [], ''));

        $target = (object) ['result' => (object) ['id' => 'x']];

        $this->assertSame('x', $response->get($target, 'result.id'));
    }

    #[Test]
    public function shouldCastToString()
    {
        $response = new Response(new PsrResponse(200, [], 'raw body'));

        $this->assertSame('raw body', (string) $response);
    }
}
