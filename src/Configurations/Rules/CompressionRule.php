<?php

namespace Cloudflare\Configurations\Rules;

class CompressionRule extends Rule
{
    /**
     * The action to perform when the rule matches. (compress_response)
     * @var string
     */
    protected string $action = 'compress_response';

    /**
     * @param string $algorithm Custom order for compression algorithms. Allowed values: `none`, `auto`, `default`, `gzip`, `brotli`
     */
    public function __construct(
        private string $algorithm
    ) {
    }

    /**
     * The parameters configuring the rule's action.
     * @return ?array
     */
    protected function getActionParameters(): array
    {
        return [
            'algorithms' => [
                'name' => $this->algorithm,
            ]
        ];
    }
}
