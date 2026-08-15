<?php

namespace Cloudflare\Endpoints\User;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\ResponseInterface;

class Invites extends AbstractEndpoint
{
    /**
     * Lists all invitations associated with my user.
     *
     * @link https://developers.cloudflare.com/api/resources/user/subresources/invites/methods/list/
     *
     * @return ResponseInterface List Invites response.
     */
    public function list(): ResponseInterface
    {
        return $this->getHttpClient()->get('/user/invites');
    }

    /**
     * Gets the details of an invitation.
     *
     * @link https://developers.cloudflare.com/api/resources/user/subresources/invites/methods/get/
     *
     * @param string $inviteId Invite identifier tag.
     *
     * @return ResponseInterface Invite Details response.
     */
    public function get(string $inviteId): ResponseInterface
    {
        return $this->getHttpClient()->get("/user/invites/{$inviteId}");
    }

    /**
     * Responds to an invitation.
     *
     * @link https://developers.cloudflare.com/api/resources/user/subresources/invites/methods/edit/
     *
     * @param string $inviteId Invite identifier tag.
     * @param string $status Status of the invitation, e.g. accepted, rejected.
     *
     * @return ResponseInterface Respond to Invite response.
     */
    public function respond(string $inviteId, string $status): ResponseInterface
    {
        return $this->getHttpClient()->patch("/user/invites/{$inviteId}", [
            'status' => $status,
        ]);
    }
}
