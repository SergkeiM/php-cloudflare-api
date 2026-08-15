<?php

namespace Cloudflare\Endpoints\User;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\ResponseInterface;

/**
 * What Cloudflare is allowed to email the authenticated user about, and in
 * which language.
 *
 * @link https://developers.cloudflare.com/fundamentals/account/
 */
class CommunicationPreferences extends AbstractEndpoint
{
    /**
     * Get the communication preferences of the authenticated user.
     *
     * Includes email verification status, marketing opt-in state and the
     * language locale.
     *
     * @link https://developers.cloudflare.com/api/resources/user/
     *
     * @return ResponseInterface Get communication preferences response
     */
    public function get(): ResponseInterface
    {
        return $this->getHttpClient()->get('/user/communication_preferences');
    }

    /**
     * Update the communication preferences of the authenticated user.
     *
     * Only the preferences named are changed, and email verification settings
     * are not touched by this endpoint at all.
     *
     * ```php
     * $client->user()->communicationPreferences()->update([
     *     'preferences' => ['marketing' => true],
     *     'language-locale' => 'en-US',
     * ]);
     * ```
     *
     * @link https://developers.cloudflare.com/api/resources/user/
     *
     * @param array $values `preferences`, a map of preference key to subscription state, and `language-locale`, one of `en-US`, `es-ES`, `de-DE`, `fr-FR`, `it-IT`, `ja-JP`, `ko-KR`, `pt-BR`, `zh-CN` or `zh-TW`. Omitting the locale leaves it unchanged.
     *
     * @return ResponseInterface Update communication preferences response
     */
    public function update(array $values): ResponseInterface
    {
        return $this->getHttpClient()->put('/user/communication_preferences', $values);
    }
}
