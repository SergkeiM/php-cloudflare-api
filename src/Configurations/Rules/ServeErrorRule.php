<?php

namespace Cloudflare\Configurations\Rules;

class ServeErrorRule extends Rule
{
    /**
     * The action to perform when the rule matches. (serve_error)
     * @var string
     */
    protected string $action = 'serve_error';

    /**
     * Serve an error response.
     *
     * Cloudflare requires the content type. Give it either the `$content` to
     * return inline, or an asset name through `setActionParameters()` for a
     * custom error asset.
     *
     * @param string $contentType Media type of the response, e.g. `text/html` or `application/json`.
     * @param string|null $content The content to return.
     * @param int|null $statusCode Status code to answer with. Cloudflare uses the original response's status when omitted.
     */
    public function __construct(
        private string $contentType,
        private ?string $content = null,
        private ?int $statusCode = null
    ) {
    }

    /**
     * The parameters configuring the rule's action.
     * @return ?array
     */
    protected function getActionParameters(): ?array
    {
        $parameters = [
            'content_type' => $this->contentType,
        ];

        if (!is_null($this->content)) {
            $parameters['content'] = $this->content;
        }

        if (!is_null($this->statusCode)) {
            $parameters['status_code'] = $this->statusCode;
        }

        return $parameters;
    }
}
