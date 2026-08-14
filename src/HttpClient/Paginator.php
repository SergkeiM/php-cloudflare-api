<?php

namespace Cloudflare\HttpClient;

use Closure;
use Generator;
use IteratorAggregate;
use Cloudflare\Contracts\ResponseInterface;
use Cloudflare\Exceptions\InvalidArgumentException;

/**
 * Lazily walks every page of a Cloudflare list endpoint.
 *
 * Cloudflare returns lists one page at a time, describing the rest in the
 * `result_info` envelope. This iterator hides that: it requests a page, yields
 * the entries of its `result`, then asks for the next one, until Cloudflare
 * runs out of pages.
 *
 * Both schemes the API uses are handled — the `page`/`per_page` counters most
 * endpoints expose, and the opaque `cursor` used by R2 and Workers KV — picked
 * from whatever the first response reports.
 *
 * ```php
 * $zones = $client->paginate(
 *     fn (array $params) => $client->zones()->list('ACCOUNT_ID', $params),
 *     ['per_page' => 100]
 * );
 *
 * foreach ($zones as $zone) {
 *     echo $zone['name'];
 * }
 * ```
 *
 * Nothing is requested until iteration starts, and pages are fetched as they
 * are consumed, so breaking out of the loop early stops the requests too.
 *
 * @implements IteratorAggregate<int, mixed>
 *
 * @author Sergkei Melingk <sergio11of@gmail.com>
 */
final class Paginator implements IteratorAggregate
{
    /**
     * Fetches a single page. Receives the query parameters for that page and
     * returns the response.
     *
     * @var Closure(array): ResponseInterface
     */
    private readonly Closure $fetch;

    /**
     * @param callable(array): ResponseInterface $fetch Fetches one page from the query parameters it is given.
     * @param array $params Query Parameters sent with the first page, and carried over to every page after it.
     *
     * @return void
     */
    public function __construct(callable $fetch, private readonly array $params = [])
    {
        $this->fetch = $fetch instanceof Closure ? $fetch : Closure::fromCallable($fetch);
    }

    /**
     * Iterate over every entry of every page.
     *
     * @throws InvalidArgumentException When the endpoint does not answer with a list.
     * @return Generator<int, mixed>
     */
    public function getIterator(): Generator
    {
        foreach ($this->pages() as $page) {
            foreach ($this->results($page) as $result) {
                yield $result;
            }
        }
    }

    /**
     * Iterate over the pages themselves, rather than their entries.
     *
     * Useful when a whole page is the unit of work — writing a batch to a
     * database, say — or when the envelope is needed alongside the results.
     *
     * @throws InvalidArgumentException When the endpoint does not answer with a list.
     * @return Generator<int, ResponseInterface>
     */
    public function pages(): Generator
    {
        $params = $this->params;

        while (true) {

            $response = ($this->fetch)($params);

            if (!$response instanceof ResponseInterface) {
                throw new InvalidArgumentException(sprintf('The paginated request must return a %s.', ResponseInterface::class));
            }

            yield $response;

            $results = $this->results($response);

            // An empty page is the end of the list, whatever the envelope claims.
            if ($results === []) {
                return;
            }

            $next = $this->nextParams($params, $response, count($results));

            if ($next === null) {
                return;
            }

            $params = $next;
        }
    }

    /**
     * Collect every entry of every page into a single array.
     *
     * Convenient for small lists, but it holds the whole collection in memory
     * and cannot be interrupted — iterate the paginator itself for large ones.
     *
     * @throws InvalidArgumentException When the endpoint does not answer with a list.
     * @return array<int, mixed>
     */
    public function all(): array
    {
        return iterator_to_array($this, false);
    }

    /**
     * Read the results of a page.
     *
     * @param ResponseInterface $response
     *
     * @throws InvalidArgumentException
     * @return array<int, mixed>
     */
    private function results(ResponseInterface $response): array
    {
        $result = $response->json('result');

        // Cloudflare answers an empty list with `null` on a handful of endpoints.
        if ($result === null) {
            return [];
        }

        if (!is_array($result) || !array_is_list($result)) {
            throw new InvalidArgumentException('The paginated request did not return a list of results, so it cannot be paginated.');
        }

        return $result;
    }

    /**
     * Build the query parameters for the page after this one.
     *
     * @param array $params Parameters the current page was requested with.
     * @param ResponseInterface $response
     * @param int $count Entries the current page returned.
     *
     * @return array|null The next page's parameters, or null once the list is exhausted.
     */
    private function nextParams(array $params, ResponseInterface $response, int $count): ?array
    {
        $info = $response->json('result_info');

        // Endpoints that return everything at once have no envelope to follow.
        if (!is_array($info)) {
            return null;
        }

        $cursor = $info['cursors']['after'] ?? $info['cursor'] ?? null;

        if (is_string($cursor) && $cursor !== '') {

            // A cursor pointing at the page just read would loop forever.
            if (($params['cursor'] ?? null) === $cursor) {
                return null;
            }

            return array_merge($params, ['cursor' => $cursor]);
        }

        // Taken from the request rather than the response, so the page number
        // always advances even if Cloudflare reports the same one twice.
        $page = (int) ($params['page'] ?? $info['page'] ?? 1);

        $totalPages = $this->totalPages($info);

        if ($totalPages !== null) {

            if ($page >= $totalPages) {
                return null;
            }

        } else {

            // Without totals, a page that came back short is the last one, and
            // a page size we cannot determine leaves nothing to walk with.
            $perPage = (int) ($info['per_page'] ?? $params['per_page'] ?? 0);

            if ($perPage <= 0 || $count < $perPage) {
                return null;
            }
        }

        return array_merge($params, ['page' => max(1, $page) + 1]);
    }

    /**
     * Total number of pages, as reported or as implied by the totals.
     *
     * @param array $info The `result_info` envelope.
     *
     * @return int|null
     */
    private function totalPages(array $info): ?int
    {
        if (isset($info['total_pages'])) {
            return (int) $info['total_pages'];
        }

        $perPage = (int) ($info['per_page'] ?? 0);

        if (isset($info['total_count']) && $perPage > 0) {
            return (int) ceil((int) $info['total_count'] / $perPage);
        }

        return null;
    }
}
