<?php

namespace Cloudflare\Configurations\Rules;

use Closure;
use Cloudflare\Contracts\Configuration;
use Cloudflare\ExpressionBuilder;
use Cloudflare\Exceptions\ConfigurationException;

abstract class Rule implements Configuration
{
    /**
     * The action to perform when the rule matches.
     * @var string
     */
    protected string $action;

    /**
     * The parameters configuring the rule's action.
     * @var mixed
     */
    protected mixed $actionParameters;

    /**
     * The expression defining which traffic will match the rule.
     * @var string|ExpressionBuilder
     */
    protected null|string|ExpressionBuilder $expression = null;

    /**
     * Whether to generate a log when the rule matches.
     * @var bool
     */
    protected bool $logging = false;

    /**
     * Whether the rule should be executed.
     * @var bool
     */
    protected bool $enabled = false;

    /**
     * The id of the rule.
     * @var string
     */
    protected null|string $id = null;

    /**
     * The reference of the rule (the rule ID by default).
     * @var string
     */
    protected null|string $ref = null;

    /**
     * An informative description of the rule.
     * @var string
     */
    protected null|string $description = null;

    /**
     * Get Rule ID
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Enable Rule.
     * @return \Cloudflare\Configurations\Rules\Rule
     */
    public function enable(): self
    {
        $this->enabled = true;

        return $this;
    }

    /**
     * Disable Rule.
     * @return \Cloudflare\Configurations\Rules\Rule
     */
    public function disable(): self
    {
        $this->enabled = false;

        return $this;
    }

    /**
     * Enable logging.
     * @return \Cloudflare\Configurations\Rules\Rule
     */
    public function enableLogging(): self
    {
        $this->logging = true;

        return $this;
    }

    /**
     * Disable logging.
     * @return \Cloudflare\Configurations\Rules\Rule
     */
    public function disableLogging(): self
    {
        $this->logging = false;

        return $this;
    }

    /**
     * Set an informative description of the rule.
     * @param string $description
     * @return \Cloudflare\Configurations\Rules\Rule
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * The id of the rule.
     * @param string $id
     * @return \Cloudflare\Configurations\Rules\Rule
     */
    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * The reference of the rule (the rule ID by default).
     * @param string $reference
     * @return \Cloudflare\Configurations\Rules\Rule
     */
    public function setRef(string $reference): self
    {
        $this->ref = $reference;

        return $this;
    }

    /**
     * The expression defining which traffic will match the rule.
     * @param string|Closure|\Cloudflare\ExpressionBuilder $expression
     * @return \Cloudflare\Configurations\Rules\Rule
     */
    public function setExpression(string|ExpressionBuilder|Closure $expression): self
    {

        if($expression instanceof Closure) {

            $bilder = new ExpressionBuilder();

            $this->expression = (string)$expression($bilder);

        } else {
            $this->expression = (string)$expression;
        }

        return $this;
    }

    abstract protected function getActionParameters(): ?array;

    public function toArray(): array
    {

        if(empty($expression = $this->expression)) {
            throw new ConfigurationException('Expression is required.');
        }

        $options = [
            'action' => $this->action,
            'enabled' => $this->enabled,
            'logging' => [
                'enabled' => $this->logging
            ],
            'expression' => $expression
        ];

        if(!is_null($actionParameters = $this->getActionParameters())) {
            $options['action_parameters'] = $actionParameters;
        }

        if(!is_null($this->description)) {
            $options['description'] = $this->description;
        }

        if(!is_null($this->id)) {
            $options['id'] = $this->id;
        }

        if(!is_null($this->ref)) {
            $options['ref'] = $this->ref;
        }

        return $options;
    }
}
