<?php

namespace Cloudflare\Endpoints;

use Cloudflare\Contracts\ResponseInterface;
use Cloudflare\Exceptions\MissingArgumentException;

class D1 extends AbstractEndpoint
{
    /**
     * Returns a list of D1 databases.
     *
     * @link https://developers.cloudflare.com/api/operations/cloudflare-d1-list-databases
     *
     * @param string $accountId Account Identifier.
     * @param array $params Query Parameters.
     *
     * @return \Cloudflare\Contracts\ResponseInterface List D1 databases response
     */
    public function list(string $accountId, array $params = []): ResponseInterface
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/d1/database", $params);
    }

    /**
     * Create D1 Database
     *
     * @link https://developers.cloudflare.com/api/operations/cloudflare-d1-create-database#request-body
     *
     * @param string $accountId Account Identifier.
     * @param string $name Database name Match pattern: `^[a-z0-9][a-z0-9-_]*$`
     * @param string $location Specify the region to create the D1 primary, if available. If this option is omitted, the D1 will be created as close as possible to the current user. Allowed values: `wnam`,`enam`,`weur`,`eeur`,`apac`,`oc`
     *
     * @return \Cloudflare\Contracts\ResponseInterface Returns the created D1 database's metadata
     */
    public function create(string $accountId, string $name, string $location = null): ResponseInterface
    {

        $body = [
            'name' => $name
        ];

        if(!is_null($location)) {
            $body['primary_location_hint'] = $location;
        }

        return $this->getHttpClient()->post("/accounts/{$accountId}/d1/database", $body);
    }

    /**
     * Returns the specified D1 database.
     *
     * @link https://developers.cloudflare.com/api/operations/cloudflare-d1-get-database
     *
     * @param string $accountId Account Identifier.
     * @param string $databaseId Database Identifier.
     *
     * @return \Cloudflare\Contracts\ResponseInterface Database details response
     */
    public function details(string $accountId, string $databaseId): ResponseInterface
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/d1/database/{$databaseId}");
    }

    /**
     * Deletes the specified D1 database.
     *
     * @link https://developers.cloudflare.com/api/operations/cloudflare-d1-delete-database
     *
     * @param string $accountId Account Identifier.
     * @param string $databaseId Database Identifier.
     *
     * @return \Cloudflare\Contracts\ResponseInterface Delete D1 database response
     */
    public function delete(string $accountId, string $databaseId): ResponseInterface
    {
        return $this->getHttpClient()->delete("/accounts/{$accountId}/d1/database/{$databaseId}");
    }

    /**
     * Returns a URL where the SQL contents of your D1 can be downloaded. Note: this process may take some time for larger DBs, during which your D1 will be unavailable to serve queries. To avoid blocking your DB unnecessarily, an in-progress export must be continually polled or will automatically cancel.
     *
     * @link https://developers.cloudflare.com/api/operations/cloudflare-d1-export-database
     *
     * @param string $accountId Account Identifier.
     * @param string $databaseId Database Identifier.
     * @param string $currentBookmark To poll an in-progress export, provide the current bookmark (returned by your first polling response)
     * @param bool $noData Export only the table definitions, not their contents
     * @param bool $noSchema Export only each table's contents, not its definition
     * @param array[string] $tables Filter the export to just one or more tables. Passing an empty array is the same as not passing anything and means: export all tables.
     *
     * @return \Cloudflare\Contracts\ResponseInterface Polled successfully, task no longer running (errored or complete)
     */
    public function export(
        string $accountId,
        string $databaseId,
        string $currentBookmark = null,
        bool $noData = false,
        bool $noSchema = false,
        array $tables = []
    ): ResponseInterface {
        $body = [
            'output_format' => 'polling',
            'no_data' => $noData,
            'no_schema' => $noSchema,
            'tables' => $tables,
        ];

        if(!is_null($currentBookmark)) {
            $body['current_bookmark'] = $currentBookmark;
        }

        return $this->getHttpClient()->post("/accounts/{$accountId}/d1/database/{$databaseId}/export", $body);
    }

    /**
     * Generates a temporary URL for uploading an SQL file to, then instructing the D1 to import it and polling it for status updates. Imports block the D1 for their duration.
     *
     * @link https://developers.cloudflare.com/api/operations/cloudflare-d1-import-database
     *
     * @param string $accountId Account Identifier.
     * @param string $databaseId Database Identifier.
     * @param string $action
     *  - `init`: Indicates you have a new SQL file to upload.
     *  - `ingest`: Indicates you've finished uploading to tell the D1 to start consuming it
     *  - `poll`: Indicates you've finished uploading to tell the D1 to start consuming it
     * @param string $etag Required when action is `init` or `ingest`. An md5 hash of the file you're uploading. Used to check if it already exists, and validate its contents before ingesting.
     * @param string $filename The filename you have successfully uploaded.
     * @param string $currentBookmark This identifies the currently-running import, checking its status.
     *
     * @return \Cloudflare\Contracts\ResponseInterface Successful action. Import is either ready to start, under way, or finished (succeeded or failed).
     */
    public function import(
        string $accountId,
        string $databaseId,
        string $action = 'init',
        string $etag = null,
        string $filename = null,
        string $currentBookmark = null
    ): ResponseInterface {

        $body = [
            'action' => $action,
        ];

        if($action === 'ingest' && is_null($filename)) {
            throw new MissingArgumentException(['filename']);
        }

        if($action === 'poll' && is_null($currentBookmark)) {
            throw new MissingArgumentException(['current_bookmark']);
        }

        if(in_array($action, ['init', 'ingest']) && is_null($etag)) {
            throw new MissingArgumentException(['etag']);
        }

        if(in_array($action, ['init', 'ingest'])) {
            $body['etag'] = $etag;
        }

        if($action === 'ingest') {
            $body['filename'] = $filename;
        }

        if($action === 'poll') {
            $body['current_bookmark'] = $currentBookmark;
        }

        return $this->getHttpClient()->post("/accounts/{$accountId}/d1/database/{$databaseId}/import", $body);
    }

    /**
     * Returns the query result as an object.
     *
     * @link https://developers.cloudflare.com/api/operations/cloudflare-d1-query-database
     *
     * @param string $accountId Account Identifier.
     * @param string $databaseId Database Identifier.
     * @param string $query Your SQL query. Supports multiple statements, joined by semicolons, which will be executed as a batch.
     * @param array[string] $params Query params.
     *
     * @return \Cloudflare\Contracts\ResponseInterface Query response
     */
    public function query(string $accountId, string $databaseId, string $query, array $params = []): ResponseInterface
    {
        $body = [
            'sql' => $query,
            'params' => $params,
        ];

        return $this->getHttpClient()->post("/accounts/{$accountId}/d1/database/{$databaseId}/query", $body);
    }

    /**
     * Returns the query result rows as arrays rather than objects. This is a performance-optimized version of the /query endpoint.
     *
     * @link https://developers.cloudflare.com/api/operations/cloudflare-d1-raw-database-query
     *
     * @param string $accountId Account Identifier.
     * @param string $databaseId Database Identifier.
     * @param string $query Your SQL query. Supports multiple statements, joined by semicolons, which will be executed as a batch.
     * @param array[string] $params Query params.
     *
     * @return \Cloudflare\Contracts\ResponseInterface Raw query response
     */
    public function raw(string $accountId, string $databaseId, string $query, array $params = []): ResponseInterface
    {
        $body = [
            'sql' => $query,
            'params' => $params,
        ];

        return $this->getHttpClient()->post("/accounts/{$accountId}/d1/database/{$databaseId}/raw", $body);
    }
}
