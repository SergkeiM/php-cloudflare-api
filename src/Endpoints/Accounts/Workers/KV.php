<?php

namespace SergkeiM\CloudFlare\Endpoints\Accounts\Workers;

use SergkeiM\CloudFlare\Endpoints\AbstractEndpoint;
use SergkeiM\CloudFlare\Contracts\CloudFlareResponse;
use SergkeiM\CloudFlare\Exceptions\BadMethodCallException;

class KV extends AbstractEndpoint
{
    /**
     * Returns the namespaces owned by an account.
     *
     * @link https://developers.cloudflare.com/api/operations/workers-kv-namespace-list-namespaces
     *
     * @param string $accountId Account identifier.
     * @param array $params Array containing the necessary params.
     *
     * @return CloudFlareResponse List Namespaces response
     */
    public function list(string $accountId, array $params): CloudFlareResponse
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/storage/kv/namespaces", $params);
    }

    /**
     * Creates a namespace under the given title. A 400 is returned if the account already owns a namespace with this title. A namespace must be explicitly deleted to be replaced.
     *
     * @link https://developers.cloudflare.com/api/operations/workers-kv-namespace-create-a-namespace
     *
     * @param string $accountId Account identifier.
     * @param string $title A human-readable string name for a Namespace.
     *
     * @return CloudFlareResponse Create a Namespace response
     */
    public function create(string $accountId, string $title): CloudFlareResponse
    {

        return $this->getHttpClient()->post("/accounts/{$accountId}/storage/kv/namespaces", [
            'title' => $title
        ]);
    }

    /**
     * Get the namespace corresponding to the given ID.
     *
     * @link https://developers.cloudflare.com/api/operations/workers-kv-namespace-get-a-namespace
     *
     * @param string $accountId Account identifier.
     * @param string $namespaceId Namespace identifier tag.
     *
     * @return CloudFlareResponse Get a Namespace response
     */
    public function details(string $accountId, string $namespaceId): CloudFlareResponse
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/storage/kv/namespaces/{$namespaceId}");
    }

    /**
     * Modifies a namespace's title.
     *
     * @link https://developers.cloudflare.com/api/operations/workers-kv-namespace-rename-a-namespace
     *
     * @param string $accountId Account identifier.
     * @param string $namespaceId Namespace identifier tag.
     * @param string $title A human-readable string name for a Namespace.
     *
     * @return CloudFlareResponse Update Member response
     */
    public function update(string $accountId, string $namespaceId, string $title): CloudFlareResponse
    {
        return $this->getHttpClient()->put("/accounts/{$accountId}/storage/kv/namespaces/{$namespaceId}", [
            'title' => $title
        ]);
    }

    /**
     * Deletes the namespace corresponding to the given ID.
     *
     * @link https://developers.cloudflare.com/api/operations/workers-kv-namespace-remove-a-namespace
     *
     * @param string $accountId Account identifier.
     * @param string $namespaceId Namespace identifier tag.
     *
     * @return CloudFlareResponse Remove a Namespace response
     */
    public function delete(string $accountId, string $namespaceId): CloudFlareResponse
    {
        return $this->getHttpClient()->delete("/accounts/{$accountId}/storage/kv/namespaces/{$namespaceId}");
    }

    /**
     * Lists a namespace keys.
     *
     * @link https://developers.cloudflare.com/api/operations/workers-kv-namespace-list-a-namespace'-s-keys
     *
     * @param string $accountId Account identifier.
     * @param string $namespaceId Namespace identifier tag.
     * @param array $params Array containing the necessary params.
     *
     * @return CloudFlareResponse Delete multiple key-value pairs response
     */
    public function listKeys(string $accountId, string $namespaceId, array $params): CloudFlareResponse
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/storage/kv/namespaces/{$namespaceId}/keys", $params);
    }

    /**
     * Returns the metadata associated with the given key in the given namespace. Use URL-encoding to use special characters (for example, `:`, `!`, `%`) in the key name.
     *
     * @link https://developers.cloudflare.com/api/operations/workers-kv-namespace-list-a-namespace'-s-keys
     *
     * @param string $accountId Account identifier.
     * @param string $namespaceId Namespace identifier tag.
     * @param string $keyName A key's name. The name may be at most 512 bytes. All printable, non-whitespace characters are valid. Use percent-encoding to define key names as part of a URL.
     *
     * @return CloudFlareResponse Read the metadata for a key response
     */
    public function keyMetadata(string $accountId, string $namespaceId, string $keyName): CloudFlareResponse
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/storage/kv/namespaces/{$namespaceId}/metadata/{$keyName}");
    }

    /**
     * Returns the value associated with the given key in the given namespace. Use URL-encoding to use special characters (for example, `:`, `!`, `%`) in the key name. If the KV-pair is set to expire at some point, the expiration time as measured in seconds since the UNIX epoch will be returned in the expiration response header.
     *
     * @link https://developers.cloudflare.com/api/operations/workers-kv-namespace-read-key-value-pair
     *
     * @param string $accountId Account identifier.
     * @param string $namespaceId Namespace identifier tag.
     * @param string $keyName A key's name. The name may be at most 512 bytes. All printable, non-whitespace characters are valid. Use percent-encoding to define key names as part of a URL.
     *
     * @return CloudFlareResponse Read key-value pair response
     */
    public function keyDetails(string $accountId, string $namespaceId, string $keyName): CloudFlareResponse
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/storage/kv/namespaces/{$namespaceId}/values/{$keyName}");
    }

    /**
     * Write a value identified by a key. Use URL-encoding to use special characters (for example, `:`, `!`, `%`) in the key name.
     * Body should be the value to be stored along with JSON metadata to be associated with the key/value pair.
     * Existing values, expirations, and metadata will be overwritten. If neither `expiration` nor `expiration_ttl` is specified, the key-value pair will never expire.
     * If both are set, `expiration_ttl` is used and `expiration` is ignored.
     *
     * @link https://developers.cloudflare.com/api/operations/workers-kv-namespace-create-a-namespace
     *
     * @param string $accountId Account identifier.
     * @param string $namespaceId Namespace identifier tag.
     * @param string $keyName A key's name. The name may be at most 512 bytes. All printable, non-whitespace characters are valid. Use percent-encoding to define key names as part of a URL.
     * @param array $values keys and values.
     *
     * @return CloudFlareResponse Write key-value pair with metadata response
     */
    public function writeKeyWithMetadata(string $accountId, string $namespaceId, string $keyName, array $values): CloudFlareResponse
    {

        return $this->getHttpClient()->put("/accounts/{$accountId}/storage/kv/namespaces/{$namespaceId}/values/{$keyName}", $values);
    }

    /**
     * Remove multiple KV pairs from the namespace. Body should be an array of up to 10,000 keys to be removed.
     *
     * @link https://developers.cloudflare.com/api/operations/workers-kv-namespace-delete-multiple-key-value-pairs
     *
     * @param string $accountId Account identifier.
     * @param string $namespaceId Namespace identifier tag.
     * @param string $keyName A key's name. The name may be at most 512 bytes. All printable, non-whitespace characters are valid. Use percent-encoding to define key names as part of a URL.
     *
     * @return CloudFlareResponse Delete key-value pair response
     */
    public function deleteKey(string $accountId, string $namespaceId, string $keyName): CloudFlareResponse
    {
        return $this->getHttpClient()->delete("/accounts/{$accountId}/storage/kv/namespaces/{$namespaceId}/values/{$keyName}");
    }

    /**
     * Write multiple keys and values at once. Body should be an array of up to 10,000 key-value pairs to be stored, along with optional expiration information.
     * Existing values and expirations will be overwritten. If neither `expiration` nor `expiration_ttl` is specified, the key-value pair will never expire.
     * If both are set, `expiration_ttl` is used and `expiration` is ignored. The entire request size must be 100 megabytes or less.
     *
     * @link https://developers.cloudflare.com/api/operations/workers-kv-namespace-write-multiple-key-value-pairs
     *
     * @param string $accountId Account identifier.
     * @param string $namespaceId Namespace identifier tag.
     * @param array $values keys and values.
     *
     * @return CloudFlareResponse Write multiple key-value pairs response
     */
    public function writeMultipleKeys(string $accountId, string $namespaceId, array $values): CloudFlareResponse
    {
        return $this->getHttpClient()->put("/accounts/{$accountId}/storage/kv/namespaces/{$namespaceId}/bulk", $values);
    }

    /**
     * Remove multiple KV pairs from the namespace. Body should be an array of up to 10,000 keys to be removed.
     *
     * @link https://developers.cloudflare.com/api/operations/workers-kv-namespace-delete-multiple-key-value-pairs
     *
     * @param string $accountId Account identifier.
     * @param string $namespaceId Namespace identifier tag.
     * @param array $keys Keys.
     *
     * @return CloudFlareResponse Delete multiple key-value pairs response
     */
    public function deleteMultipleKeys(string $accountId, string $namespaceId, array $keys): CloudFlareResponse
    {
        return $this->getHttpClient()->delete("/accounts/{$accountId}/storage/kv/namespaces/{$namespaceId}/bulk/delete", $keys);
    }
}