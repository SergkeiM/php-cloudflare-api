<?php

namespace Cloudflare\Tests;

use Cloudflare\ClientOptions;
use Cloudflare\Exceptions\InvalidArgumentException;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

class ClientOptionsTest extends TestCase
{
    #[Test]
    public function shouldFallBackToDefaults()
    {
        $options = new ClientOptions();

        $this->assertSame(ClientOptions::DEFAULT_BASE_URL, $options->baseUrl);
        $this->assertSame(ClientOptions::DEFAULT_TIMEOUT, $options->timeout);
        $this->assertSame(ClientOptions::DEFAULT_CONNECT_TIMEOUT, $options->connectTimeout);
        $this->assertSame([], $options->headers);
        $this->assertSame([], $options->middlewares);
        $this->assertSame(ClientOptions::DEFAULT_MAX_RETRIES, $options->maxRetries);
    }

    #[Test]
    public function shouldAcceptMaxRetries()
    {
        $this->assertSame(5, (new ClientOptions(maxRetries: 5))->maxRetries);
        $this->assertSame(0, (new ClientOptions(maxRetries: 0))->maxRetries);
    }

    #[Test]
    public function shouldRejectNegativeMaxRetries()
    {
        $this->expectException(InvalidArgumentException::class);

        new ClientOptions(maxRetries: -1);
    }

    #[Test]
    public function shouldAcceptOverrides()
    {
        $middleware = fn (callable $handler) => $handler;

        $options = new ClientOptions(
            baseUrl: 'https://mock.test/v4',
            timeout: 120.5,
            connectTimeout: 2.5,
            headers: ['X-Trace' => 'abc'],
            middlewares: [$middleware],
        );

        $this->assertSame('https://mock.test/v4/', $options->baseUrl);
        $this->assertSame(120.5, $options->timeout);
        $this->assertSame(2.5, $options->connectTimeout);
        $this->assertSame(['X-Trace' => 'abc'], $options->headers);
        $this->assertSame([$middleware], $options->middlewares);
    }

    #[TestWith(['https://mock.test/v4', 'https://mock.test/v4/'])]
    #[TestWith(['https://mock.test/v4/', 'https://mock.test/v4/'])]
    #[TestWith(['https://mock.test/v4///', 'https://mock.test/v4/'])]
    #[TestWith(['  https://mock.test  ', 'https://mock.test/'])]
    #[TestWith(['http://localhost:8080', 'http://localhost:8080/'])]
    #[Test]
    public function shouldNormalizeBaseUrl(string $given, string $expected)
    {
        $this->assertSame($expected, (new ClientOptions(baseUrl: $given))->baseUrl);
    }

    #[Test]
    public function shouldTreatNullBaseUrlAsDefault()
    {
        $this->assertSame(ClientOptions::DEFAULT_BASE_URL, (new ClientOptions(baseUrl: null))->baseUrl);
    }

    #[TestWith([''])]
    #[TestWith(['   '])]
    #[TestWith(['not-a-url'])]
    #[TestWith(['/client/v4'])]
    #[TestWith(['ftp://mock.test'])]
    #[TestWith(['https://'])]
    #[Test]
    public function shouldRejectInvalidBaseUrl(string $baseUrl)
    {
        $this->expectException(InvalidArgumentException::class);

        new ClientOptions(baseUrl: $baseUrl);
    }

    #[Test]
    public function shouldAllowZeroTimeouts()
    {
        $options = new ClientOptions(timeout: 0, connectTimeout: 0);

        $this->assertSame(0.0, $options->timeout);
        $this->assertSame(0.0, $options->connectTimeout);
    }

    #[Test]
    public function shouldRejectNegativeTimeout()
    {
        $this->expectException(InvalidArgumentException::class);

        new ClientOptions(timeout: -1);
    }

    #[Test]
    public function shouldRejectNegativeConnectTimeout()
    {
        $this->expectException(InvalidArgumentException::class);

        new ClientOptions(connectTimeout: -1);
    }

    #[Test]
    public function shouldAcceptArrayHeaderValues()
    {
        $options = new ClientOptions(headers: ['X-Multi' => ['a', 'b']]);

        $this->assertSame(['X-Multi' => ['a', 'b']], $options->headers);
    }

    #[Test]
    public function shouldRejectEmptyHeaderName()
    {
        $this->expectException(InvalidArgumentException::class);

        new ClientOptions(headers: ['   ' => 'value']);
    }

    #[Test]
    public function shouldRejectNonStringHeaderValue()
    {
        $this->expectException(InvalidArgumentException::class);

        new ClientOptions(headers: ['X-Trace' => 123]);
    }

    #[Test]
    public function shouldRejectNonCallableMiddleware()
    {
        $this->expectException(InvalidArgumentException::class);

        new ClientOptions(middlewares: ['not-callable']);
    }
}
