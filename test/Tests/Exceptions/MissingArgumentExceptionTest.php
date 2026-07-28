<?php

namespace Cloudflare\Tests\Exceptions;

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
}
