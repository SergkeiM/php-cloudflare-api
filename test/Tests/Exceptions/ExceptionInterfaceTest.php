<?php

namespace Cloudflare\Tests\Exceptions;

use Cloudflare\Contracts\ExceptionInterface;
use Cloudflare\Exceptions\BadMethodCallException;
use Cloudflare\Exceptions\ConfigurationException;
use Cloudflare\Exceptions\InvalidArgumentException;
use Cloudflare\Exceptions\MissingArgumentException;
use Cloudflare\HttpClient\Exceptions\NotFoundException;
use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class ExceptionInterfaceTest extends TestCase
{
    use InteractsWithMockClient;

    /**
     * Guards the invariant: anything thrown by this package is catchable as one type.
     */
    #[Test]
    #[DataProvider('exceptionClassesProvider')]
    public function everyExceptionShouldImplementTheInterface(string $class)
    {
        $this->assertTrue(
            is_subclass_of($class, ExceptionInterface::class),
            sprintf('%s must implement %s.', $class, ExceptionInterface::class)
        );
    }

    #[Test]
    public function shouldCatchHttpFailuresThroughTheInterface()
    {
        $client = $this->mockClient([
            new Response(404, [], json_encode(['success' => false])),
        ]);

        $this->expectException(ExceptionInterface::class);

        $client->zones()->get('zone_id');
    }

    #[Test]
    public function shouldCatchArgumentFailuresThroughTheInterface()
    {
        $this->expectException(ExceptionInterface::class);

        (new \Cloudflare\Client('token'))->api('does_not_exist');
    }

    #[Test]
    public function shouldCatchConfigurationFailuresThroughTheInterface()
    {
        $this->expectException(ExceptionInterface::class);

        throw new ConfigurationException('nope');
    }

    /**
     * The native parents are part of the contract too, so catching an SPL type
     * still works for anyone who was already doing that.
     */
    #[Test]
    public function shouldKeepNativeParents()
    {
        $this->assertInstanceOf(\InvalidArgumentException::class, new InvalidArgumentException());
        $this->assertInstanceOf(\BadMethodCallException::class, new BadMethodCallException());
        $this->assertInstanceOf(\InvalidArgumentException::class, new MissingArgumentException('id'));
        $this->assertInstanceOf(\Exception::class, new ConfigurationException());
        $this->assertInstanceOf(\Exception::class, new NotFoundException($this->response(404)));
    }

    #[Test]
    public function theInterfaceShouldBeThrowable()
    {
        $this->assertTrue(is_a(ExceptionInterface::class, \Throwable::class, true));
    }

    /**
     * Every exception class shipped by the package.
     *
     * @return array<int, array{string}>
     */
    public static function exceptionClassesProvider(): array
    {
        $root = dirname(__DIR__, 3);

        $directories = [
            $root.'/src/Exceptions' => 'Cloudflare\\Exceptions\\',
            $root.'/src/HttpClient/Exceptions' => 'Cloudflare\\HttpClient\\Exceptions\\',
        ];

        $classes = [];

        foreach ($directories as $directory => $namespace) {
            foreach (glob($directory.'/*.php') as $file) {
                $classes[] = [$namespace.basename($file, '.php')];
            }
        }

        return $classes;
    }

    /**
     * @param int $status
     * @return \Cloudflare\HttpClient\Response
     */
    private function response(int $status): \Cloudflare\HttpClient\Response
    {
        return new \Cloudflare\HttpClient\Response(new Response($status, [], '{}'));
    }
}
