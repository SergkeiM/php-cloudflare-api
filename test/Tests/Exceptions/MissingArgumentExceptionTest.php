<?php

namespace Cloudflare\Tests\Exceptions;

use Cloudflare\Contracts\ExceptionInterface;
use Cloudflare\Exceptions\InvalidArgumentException;
use Cloudflare\Exceptions\MissingArgumentException;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class MissingArgumentExceptionTest extends TestCase
{
    #[Test]
    public function shouldBuildMessageFromArray()
    {
        $exception = new MissingArgumentException(['name', 'type']);

        $this->assertSame(
            'One or more of required ("name", "type") parameters is missing!',
            $exception->getMessage()
        );
    }

    #[Test]
    public function shouldBuildMessageFromString()
    {
        $exception = new MissingArgumentException('name');

        $this->assertSame(
            'One or more of required ("name") parameters is missing!',
            $exception->getMessage()
        );
    }

    #[Test]
    public function shouldBeAnInvalidArgumentException()
    {
        $exception = new MissingArgumentException('name');

        $this->assertInstanceOf(InvalidArgumentException::class, $exception);
        $this->assertInstanceOf(\InvalidArgumentException::class, $exception);
        $this->assertInstanceOf(ExceptionInterface::class, $exception);
    }

    #[Test]
    public function shouldCarryCodeAndPrevious()
    {
        $previous = new \RuntimeException('root cause');

        $exception = new MissingArgumentException('name', 42, $previous);

        $this->assertSame(42, $exception->getCode());
        $this->assertSame($previous, $exception->getPrevious());
    }
}
