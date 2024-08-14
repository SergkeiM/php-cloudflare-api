<?php

namespace SergkeiM\CloudFlare\Exceptions;

use GuzzleHttp\Psr7\Message;
use SergkeiM\CloudFlare\HttpClient\Response;

class RequestException extends HttpClientException
{
    /**
     * The response instance.
     *
     * @var \SergkeiM\CloudFlare\HttpClient\Response
     */
    public $response;

    /**
     * Create a new exception instance.
     *
     * @param  \SergkeiM\CloudFlare\HttpClient\Response  $response
     * @return void
     */
    public function __construct(Response $response)
    {
        parent::__construct($this->prepareMessage($response), $response->status());

        $this->response = $response;
    }

    /**
     * Prepare the exception message.
     *
     * @param  \SergkeiM\CloudFlare\HttpClient\Response  $response
     * @return string
     */
    protected function prepareMessage(Response $response)
    {
        $message = "HTTP request returned status code {$response->status()}";

        $summary = Message::bodySummary($response->toPsrResponse());

        return is_null($summary) ? $message : $message .= ":\n{$summary}\n";
    }
}
