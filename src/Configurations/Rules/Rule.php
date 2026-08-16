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
     * Action parameters set on this rule directly, merged over whatever the
     * concrete rule builds for itself.
     * @var array
     */
    protected array $actionParameters = [];

    /**
     * Whether Cloudflare should log when the rule matches. Null leaves the
     * field out and Cloudflare applies its own default.
     * @var bool|null
     */
    protected ?bool $logging = null;

    /**
     * The expression defining which traffic will match the rule.
     * @var string|ExpressionBuilder
     */
    protected string|bool|ExpressionBuilder $expression = true;

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

        if ($expression instanceof Closure) {

            $bilder = new ExpressionBuilder();

            $this->expression = (string)$expression($bilder);

        } else {

            $this->expression = (string)$expression;

        }

        return $this;
    }

    /**
     * Set parameters on the rule's action.
     *
     * Cloudflare defines a different set for each action, and adds to them over
     * time, so they are passed through as given and merged over anything the
     * rule builds itself. Calling this twice merges rather than replaces.
     *
     * ```php
     * (new RewriteRule())->setActionParameters([
     *     'uri' => ['path' => ['value' => '/new-path']],
     * ]);
     * ```
     *
     * @param array $parameters
     * @return \Cloudflare\Configurations\Rules\Rule
     */
    public function setActionParameters(array $parameters): self
    {
        $this->actionParameters = array_merge($this->actionParameters, $parameters);

        return $this;
    }

    /**
     * Whether Cloudflare should log when the rule matches.
     *
     * Logging is a property of the rule rather than of its action, so it
     * applies whatever the action is.
     *
     * @param bool $enabled
     * @return \Cloudflare\Configurations\Rules\Rule
     */
    public function setLogging(bool $enabled): self
    {
        $this->logging = $enabled;

        return $this;
    }

    abstract protected function getActionParameters(): ?array;

    public function toArray(): array
    {
        $options = [
            'action' => $this->action,
            'enabled' => $this->enabled,
            'expression' => $this->expression
        ];

        $actionParameters = array_merge($this->getActionParameters() ?? [], $this->actionParameters);

        if ($actionParameters !== []) {
            $options['action_parameters'] = $actionParameters;
        }

        if (!is_null($this->logging)) {
            $options['logging'] = ['enabled' => $this->logging];
        }

        if (!is_null($this->description)) {
            $options['description'] = $this->description;
        }

        if (!is_null($this->id)) {
            $options['id'] = $this->id;
        }

        if (!is_null($this->ref)) {
            $options['ref'] = $this->ref;
        }

        return $options;
    }
}
