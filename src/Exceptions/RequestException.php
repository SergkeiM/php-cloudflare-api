<?php

namespace SergkeiM\CloudFlare\Exceptions;

use Psr\Http\Message\ResponseInterface;

class RequestException extends ErrorException
{
    /**
     * The response instance.
     *
     * @var \Psr\Http\Message\ResponseInterface
     */
    public $response;

    /**
     * Create a new exception instance.
     *
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @return void
     */
    public function __construct(ResponseInterface $response)
    {
        parent::__construct($this->prepareMessage($response), $response->getStatusCode());

        $this->response = $response;
    }

    /**
     * Prepare the exception message.
     *
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @return string
     */
    protected function prepareMessage(ResponseInterface $response)
    {
        $body = $response->getBody();

        $summary = null;

        if (!$body->isSeekable() || !$body->isReadable()) {
            $summary = null;
        } else {
            $size = $body->getSize();

            if ($size === 0) {
                $summary = null;
            } else {
                $body->rewind();
                $summary = $body->read(120);
                $body->rewind();

                if ($size > 120) {
                    $summary .= ' (truncated...)';
                }

                // Matches any printable character, including unicode characters:
                // letters, marks, numbers, punctuation, spacing, and separators.
                if (preg_match('/[^\pL\pM\pN\pP\pS\pZ\n\r\t]/u', $summary) !== 0) {
                    $summary = null;
                }
            }
        }

        $message = "HTTP request returned status code {$response->getStatusCode()}";

        return is_null($summary) ? $message : $message .= ":\n{$summary}\n";
    }
}
