<?php

namespace Cloudflare\Exceptions;

use GuzzleHttp\Psr7\Message;
use Cloudflare\Contracts\CloudflareResponse;

class RequestException extends HttpClientException
{
    /**
     * The response instance.
     *
     * @var \Cloudflare\Contracts\CloudflareResponse
     */
    public $response;

    /**
     * Create a new exception instance.
     *
     * @param  \Cloudflare\Contracts\CloudflareResponse  $response
     * @return void
     */
    public function __construct(CloudflareResponse $response)
    {
        parent::__construct($this->prepareMessage($response), $response->status());

        $this->response = $response;
    }

    /**
     * Prepare the exception message.
     *
     * @param  \Cloudflare\Contracts\CloudflareResponse  $response
     * @return string
     */
    protected function prepareMessage(CloudflareResponse $response)
    {
        $message = "HTTP request returned status code {$response->status()}";

        $summary = Message::bodySummary($response->toPsrResponse());

        return is_null($summary) ? $message : $message .= ":\n{$summary}\n";
    }
}
