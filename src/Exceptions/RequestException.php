<?php

namespace CloudFlare\Exceptions;

use GuzzleHttp\Psr7\Message;
use CloudFlare\Contracts\CloudFlareResponse;

class RequestException extends HttpClientException
{
    /**
     * The response instance.
     *
     * @var \CloudFlare\Contracts\CloudFlareResponse
     */
    public $response;

    /**
     * Create a new exception instance.
     *
     * @param  \CloudFlare\Contracts\CloudFlareResponse  $response
     * @return void
     */
    public function __construct(CloudFlareResponse $response)
    {
        parent::__construct($this->prepareMessage($response), $response->status());

        $this->response = $response;
    }

    /**
     * Prepare the exception message.
     *
     * @param  \CloudFlare\Contracts\CloudFlareResponse  $response
     * @return string
     */
    protected function prepareMessage(CloudFlareResponse $response)
    {
        $message = "HTTP request returned status code {$response->status()}";

        $summary = Message::bodySummary($response->toPsrResponse());

        return is_null($summary) ? $message : $message .= ":\n{$summary}\n";
    }
}
