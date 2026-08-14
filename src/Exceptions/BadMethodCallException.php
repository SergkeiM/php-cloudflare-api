<?php

namespace Cloudflare\Exceptions;

use Cloudflare\Contracts\ExceptionInterface;

class BadMethodCallException extends \BadMethodCallException implements ExceptionInterface
{
}
