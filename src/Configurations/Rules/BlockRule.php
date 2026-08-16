<?php

namespace Cloudflare\Configurations\Rules;

class BlockRule extends Rule
{
    /**
     * The action to perform when the rule matches. (block)
     * @var string
     */
    protected string $action = 'block';

    /**
     * Answer a matching request yourself instead of passing it to the origin.
     *
     * Cloudflare sends `content` as given, so encode it to match the content
     * type you declare — a JSON string for `application/json`, markup for
     * `text/html`.
     *
     * ```php
     * new BlockRule('{"error": "blocked"}', 'application/json', 403);
     * ```
     *
     * @param string $content The content to return.
     * @param string $contentType The type of the content to return.
     * @param int $statusCode The status code to return. >= 400 <= 499
     */
    public function __construct(
        private string $content,
        private string $contentType = 'application/json',
        private int $statusCode = 400,
    ) {

    }

    /**
     * The parameters configuring the rule's action.
     * @return array
     */
    protected function getActionParameters(): array
    {
        return [
            'response' => [
                'content' => $this->content,
                'content_type' => $this->contentType,
                'status_code' => $this->statusCode,
            ]
        ];
    }
}
