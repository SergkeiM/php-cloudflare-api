<?php

namespace Cloudflare\Tests\HttpClient;

use Cloudflare\Contracts\ResponseInterface;
use Cloudflare\HttpClient\Response;
use GuzzleHttp\Psr7\Response as PsrResponse;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestWith;
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

    #[TestWith([200])]
    #[TestWith([201])]
    #[TestWith([202])]
    #[TestWith([204])]
    #[TestWith([206])]
    #[TestWith([299])]
    #[Test]
    public function shouldBeSuccessfulForAny2xxStatus(int $status)
    {
        $response = new Response(new PsrResponse($status, [], ''));

        $this->assertTrue($response->successful());
        $this->assertFalse($response->failed());
    }

    #[TestWith([100])]
    #[TestWith([199])]
    #[TestWith([300])]
    #[TestWith([301])]
    #[TestWith([400])]
    #[TestWith([404])]
    #[TestWith([429])]
    #[TestWith([500])]
    #[Test]
    public function shouldFailForAnythingOutside2xx(int $status)
    {
        $response = new Response(new PsrResponse($status, [], ''));

        $this->assertTrue($response->failed());
        $this->assertFalse($response->successful());
    }

    #[Test]
    public function shouldTraverseNestedKeysWithDotNotation()
    {
        $response = new Response(new PsrResponse(200, [], json_encode([
            'result' => ['meta' => ['step' => 3]],
        ])));

        $this->assertSame(3, $response->json('result.meta.step'));
    }

    #[Test]
    public function shouldReturnDefaultWhenTraversingThroughAScalar()
    {
        $response = new Response(new PsrResponse(200, [], json_encode(['result' => 'not-an-array'])));

        $this->assertNull($response->json('result.id'));
        $this->assertSame('fallback', $response->json('result.id', 'fallback'));
    }

    #[Test]
    public function shouldNotExposeGetOnTheContract()
    {
        $this->assertFalse(
            method_exists(ResponseInterface::class, 'get'),
            'get() is an internal helper and must not be part of the response contract.'
        );
    }

    #[Test]
    public function shouldReturnEnvelopeErrors()
    {
        $response = new Response(new PsrResponse(200, [], json_encode([
            'success' => false,
            'errors' => [['code' => 1003, 'message' => 'Invalid identifier']],
            'messages' => [['code' => 1, 'message' => 'partially applied']],
        ])));

        $this->assertSame([['code' => 1003, 'message' => 'Invalid identifier']], $response->errors());
        $this->assertSame([['code' => 1, 'message' => 'partially applied']], $response->messages());
        $this->assertTrue($response->hasErrors());
    }

    #[Test]
    public function shouldReportNoErrorsOnACleanEnvelope()
    {
        $response = new Response(new PsrResponse(200, [], json_encode([
            'success' => true,
            'errors' => [],
            'messages' => [],
            'result' => ['id' => 'x'],
        ])));

        $this->assertSame([], $response->errors());
        $this->assertSame([], $response->messages());
        $this->assertFalse($response->hasErrors());
    }

    #[Test]
    public function shouldReportNoErrorsWhenTheEnvelopeIsAbsent()
    {
        $response = new Response(new PsrResponse(204, [], ''));

        $this->assertSame([], $response->errors());
        $this->assertSame([], $response->messages());
        $this->assertFalse($response->hasErrors());
    }

    /**
     * A 2xx with `"success": false` is the case a status check alone misses.
     */
    #[Test]
    public function shouldSurfaceErrorsOnASuccessfulStatus()
    {
        $response = new Response(new PsrResponse(200, [], json_encode([
            'success' => false,
            'errors' => [['code' => 10000, 'message' => 'Authentication error']],
        ])));

        $this->assertTrue($response->successful());
        $this->assertTrue($response->hasErrors());
    }

    #[Test]
    public function shouldCastToString()
    {
        $response = new Response(new PsrResponse(200, [], 'raw body'));

        $this->assertSame('raw body', (string) $response);
    }
}
