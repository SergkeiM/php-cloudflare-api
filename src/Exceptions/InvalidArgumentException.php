<?php

namespace Cloudflare\Exceptions;

use Cloudflare\Contracts\ExceptionInterface;

class InvalidArgumentException extends \InvalidArgumentException implements ExceptionInterface
{
}
