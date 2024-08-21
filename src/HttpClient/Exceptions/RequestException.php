<?php

namespace Cloudflare\HttpClient\Exceptions;

use GuzzleHttp\Psr7\Message;
use Cloudflare\Contracts\ResponseInterface;

class RequestException extends HttpClientException
{
    /**
     * The response instance.
     *
     * @var \Cloudflare\Contracts\ResponseInterface
     */
    public $response;

    /**
     * Create a new exception instance.
     *
     * @param  \Cloudflare\Contracts\ResponseInterface  $response
     * @return void
     */
    public function __construct(ResponseInterface $response)
    {
        parent::__construct($this->prepareMessage($response), $response->status());

        $this->response = $response;
    }

    /**
     * Prepare the exception message.
     *
     * @param  \Cloudflare\Contracts\ResponseInterface  $response
     * @return string
     */
    protected function prepareMessage(ResponseInterface $response)
    {
        $message = "HTTP request returned status code {$response->status()}";

        $summary = Message::bodySummary($response->toPsrResponse());

        return is_null($summary) ? $message : $message .= ":\n{$summary}\n";
    }
}
