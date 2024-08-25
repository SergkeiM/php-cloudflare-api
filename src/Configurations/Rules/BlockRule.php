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
     * @param mixed $content The content to return.
     * @param string $contentType The type of the content to return.
     * @param int $statusCode The status code to return. >= 400 <= 499
     */
    public function __construct(
        private mixed $content,
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
