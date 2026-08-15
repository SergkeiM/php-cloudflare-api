<?php

namespace Cloudflare\Endpoints\Accounts;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\ResponseInterface;

/**
 * Account-wide settings, as opposed to the per-zone toggles under
 * `$client->zones()->settings()`.
 *
 * Both endpoints here concern image transformations: one reports how the
 * per-zone setting stands across the whole account, the other controls how
 * transformations are billed.
 *
 * @link https://developers.cloudflare.com/images/transform-images/
 */
class Settings extends AbstractEndpoint
{
    /**
     * List the Image Resizing configuration of every zone in an account.
     *
     * The account-wide view of the per-zone `image_resizing` setting, which
     * saves reading it zone by zone through
     * `$client->zones()->settings()->get()`.
     *
     * @link https://developers.cloudflare.com/api/resources/images/
     *
     * @param string $accountId Account Identifier.
     *
     * @return \Cloudflare\Contracts\ResponseInterface List transformations response
     */
    public function transformations(string $accountId): ResponseInterface
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/settings/transformations");
    }

    /**
     * Get the Unique Transformations billing setting for an account.
     *
     * @link https://developers.cloudflare.com/api/resources/images/
     *
     * @param string $accountId Account Identifier.
     *
     * @return \Cloudflare\Contracts\ResponseInterface Get Unique Transformations billing response
     */
    public function uniqueTransformationsBilling(string $accountId): ResponseInterface
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/settings/ut-billing");
    }

    /**
     * Enable Unique Transformations billing for an account.
     *
     * Directs billing data to the Transformations pipeline. Cloudflare accepts
     * only `on` here: once enabled, the setting cannot be turned back off.
     *
     * @link https://developers.cloudflare.com/api/resources/images/
     *
     * @param string $accountId Account Identifier.
     * @param array $values Setting value, `['value' => 'on']`.
     *
     * @throws \Cloudflare\Exceptions\MissingArgumentException
     *
     * @return \Cloudflare\Contracts\ResponseInterface Change Unique Transformations billing response
     */
    public function updateUniqueTransformationsBilling(string $accountId, array $values = ['value' => 'on']): ResponseInterface
    {
        $this->requiredParams(['value'], $values);

        return $this->getHttpClient()->patch("/accounts/{$accountId}/settings/ut-billing", $values);
    }
}
