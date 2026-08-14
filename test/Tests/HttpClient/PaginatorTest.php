<?php

namespace Cloudflare\Tests\HttpClient;

use Cloudflare\Contracts\ResponseInterface;
use Cloudflare\Exceptions\InvalidArgumentException;
use Cloudflare\HttpClient\Exceptions\NotFoundException;
use Cloudflare\HttpClient\Paginator;
use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

class PaginatorTest extends TestCase
{
    use InteractsWithMockClient;

    #[Test]
    public function shouldWalkEveryPageReportedByTotalPages()
    {
        $client = $this->mockClient([
            $this->page([['id' => 'a'], ['id' => 'b']], ['page' => 1, 'per_page' => 2, 'total_count' => 5, 'total_pages' => 3]),
            $this->page([['id' => 'c'], ['id' => 'd']], ['page' => 2, 'per_page' => 2, 'total_count' => 5, 'total_pages' => 3]),
            $this->page([['id' => 'e']], ['page' => 3, 'per_page' => 2, 'total_count' => 5, 'total_pages' => 3]),
        ]);

        $zones = $client->paginate(
            fn (array $params) => $client->zones()->list('account_id', $params),
            ['per_page' => 2]
        );

        $this->assertSame(['a', 'b', 'c', 'd', 'e'], array_column(iterator_to_array($zones, false), 'id'));
        $this->assertCount(3, $this->requestHistory);
        $this->assertSame([null, '2', '3'], $this->requestedPages());
    }

    #[Test]
    public function shouldCarryTheSuppliedParamsOntoEveryPage()
    {
        $client = $this->mockClient([
            $this->page([['id' => 'a']], ['page' => 1, 'per_page' => 1, 'total_pages' => 2]),
            $this->page([['id' => 'b']], ['page' => 2, 'per_page' => 1, 'total_pages' => 2]),
        ]);

        $records = $client->paginate(
            fn (array $params) => $client->dns()->list('zone_id', $params),
            ['per_page' => 1, 'type' => 'A']
        );

        $this->assertCount(2, $records->all());

        $query = $this->queryOf(1);

        $this->assertSame('1', $query['per_page']);
        $this->assertSame('A', $query['type']);
        $this->assertSame('2', $query['page']);
    }

    #[Test]
    public function shouldContinueFromAPageOtherThanTheFirst()
    {
        $client = $this->mockClient([
            $this->page([['id' => 'c']], ['page' => 3, 'per_page' => 1, 'total_pages' => 4]),
            $this->page([['id' => 'd']], ['page' => 4, 'per_page' => 1, 'total_pages' => 4]),
        ]);

        $paginator = $client->getHttpClient()->paginate('/zones', ['page' => 3, 'per_page' => 1]);

        $this->assertSame(['c', 'd'], array_column($paginator->all(), 'id'));
        $this->assertSame(['3', '4'], $this->requestedPages());
    }

    #[Test]
    public function shouldFallBackToTheTotalsWhenTotalPagesIsMissing()
    {
        $client = $this->mockClient([
            $this->page([['id' => 'a'], ['id' => 'b']], ['page' => 1, 'per_page' => 2, 'total_count' => 3]),
            $this->page([['id' => 'c']], ['page' => 2, 'per_page' => 2, 'total_count' => 3]),
        ]);

        $paginator = $client->getHttpClient()->paginate('/zones');

        $this->assertCount(3, $paginator->all());
        $this->assertCount(2, $this->requestHistory);
    }

    #[Test]
    public function shouldStopOnAShortPageWhenNoTotalsAreReported()
    {
        $client = $this->mockClient([
            $this->page([['id' => 'a'], ['id' => 'b']], ['page' => 1, 'per_page' => 2]),
            $this->page([['id' => 'c']], ['page' => 2, 'per_page' => 2]),
        ]);

        $paginator = $client->getHttpClient()->paginate('/zones', ['per_page' => 2]);

        $this->assertCount(3, $paginator->all());
        $this->assertCount(2, $this->requestHistory);
    }

    #[Test]
    public function shouldStopWhenNeitherTotalsNorAPageSizeAreKnown()
    {
        $client = $this->mockClient([
            $this->page([['id' => 'a']], ['page' => 1]),
        ]);

        $paginator = $client->getHttpClient()->paginate('/zones');

        $this->assertCount(1, $paginator->all());
        $this->assertCount(1, $this->requestHistory);
    }

    #[Test]
    public function shouldTreatAMissingEnvelopeAsASinglePage()
    {
        $client = $this->mockClient([
            $this->page([['id' => 'a'], ['id' => 'b']]),
        ]);

        $paginator = $client->getHttpClient()->paginate('/ips');

        $this->assertCount(2, $paginator->all());
        $this->assertCount(1, $this->requestHistory);
    }

    #[Test]
    public function shouldFollowTheAfterCursor()
    {
        $client = $this->mockClient([
            $this->page([['id' => 'a']], ['cursors' => ['after' => 'CURSOR_1']]),
            $this->page([['id' => 'b']], ['cursors' => ['after' => 'CURSOR_2']]),
            $this->page([['id' => 'c']], ['cursors' => ['after' => '']]),
        ]);

        $paginator = $client->getHttpClient()->paginate('/accounts/account_id/r2/buckets');

        $this->assertSame(['a', 'b', 'c'], array_column($paginator->all(), 'id'));
        $this->assertSame([null, 'CURSOR_1', 'CURSOR_2'], $this->requestedCursors());
    }

    #[Test]
    public function shouldFollowAFlatCursor()
    {
        $client = $this->mockClient([
            $this->page([['id' => 'a']], ['cursor' => 'CURSOR_1']),
            $this->page([['id' => 'b']], ['count' => 1]),
        ]);

        $paginator = $client->getHttpClient()->paginate('/accounts/account_id/storage/kv/namespaces/namespace_id/keys');

        $this->assertCount(2, $paginator->all());
        $this->assertSame([null, 'CURSOR_1'], $this->requestedCursors());
    }

    #[Test]
    public function shouldStopWhenACursorRepeatsItself()
    {
        $client = $this->mockClient([
            $this->page([['id' => 'a']], ['cursor' => 'CURSOR_1']),
            $this->page([['id' => 'b']], ['cursor' => 'CURSOR_1']),
        ]);

        $paginator = $client->getHttpClient()->paginate('/accounts/account_id/r2/buckets');

        $this->assertCount(2, $paginator->all());
        $this->assertCount(2, $this->requestHistory);
    }

    #[Test]
    public function shouldPreferTheCursorOverThePageCounters()
    {
        $client = $this->mockClient([
            $this->page([['id' => 'a']], ['page' => 1, 'per_page' => 1, 'total_pages' => 9, 'cursor' => 'CURSOR_1']),
            $this->page([['id' => 'b']], ['page' => 9, 'per_page' => 1, 'total_pages' => 9]),
        ]);

        $paginator = $client->getHttpClient()->paginate('/zones', ['per_page' => 1]);

        $this->assertCount(2, $paginator->all());
        $this->assertSame([null, 'CURSOR_1'], $this->requestedCursors());
        $this->assertSame([null, null], $this->requestedPages());
    }

    #[TestWith([[]])]
    #[TestWith([null])]
    #[Test]
    public function shouldStopOnAnEmptyPage($result)
    {
        $client = $this->mockClient([
            $this->page($result, ['page' => 1, 'per_page' => 20, 'total_pages' => 5]),
        ]);

        $paginator = $client->getHttpClient()->paginate('/zones');

        $this->assertSame([], $paginator->all());
        $this->assertCount(1, $this->requestHistory);
    }

    #[Test]
    public function shouldRejectAnEndpointThatDoesNotReturnAList()
    {
        $client = $this->mockClient([
            $this->page(['id' => 'zone_id', 'name' => 'example.com']),
        ]);

        $paginator = $client->getHttpClient()->paginate('/zones/zone_id');

        $this->expectException(InvalidArgumentException::class);

        $paginator->all();
    }

    #[Test]
    public function shouldRejectAFetcherThatDoesNotReturnAResponse()
    {
        $paginator = new Paginator(fn (array $params) => ['id' => 'a']);

        $this->expectException(InvalidArgumentException::class);

        $paginator->all();
    }

    #[Test]
    public function shouldNotSendAnythingUntilIterated()
    {
        $client = $this->mockClient([
            $this->page([['id' => 'a']]),
        ]);

        $client->getHttpClient()->paginate('/zones');

        $this->assertCount(0, $this->requestHistory);
    }

    #[Test]
    public function shouldStopFetchingWhenIterationBreaksEarly()
    {
        $client = $this->mockClient([
            $this->page([['id' => 'a'], ['id' => 'b']], ['page' => 1, 'per_page' => 2, 'total_pages' => 50]),
        ]);

        foreach ($client->getHttpClient()->paginate('/zones', ['per_page' => 2]) as $zone) {
            if ($zone['id'] === 'b') {
                break;
            }
        }

        $this->assertCount(1, $this->requestHistory);
    }

    #[Test]
    public function shouldIterateWholePages()
    {
        $client = $this->mockClient([
            $this->page([['id' => 'a']], ['page' => 1, 'per_page' => 1, 'total_pages' => 2]),
            $this->page([['id' => 'b']], ['page' => 2, 'per_page' => 1, 'total_pages' => 2]),
        ]);

        $pages = [];

        foreach ($client->getHttpClient()->paginate('/zones', ['per_page' => 1])->pages() as $page) {
            $this->assertInstanceOf(ResponseInterface::class, $page);
            $pages[] = $page->json('result_info.page');
        }

        $this->assertSame([1, 2], $pages);
    }

    #[Test]
    public function shouldSurfaceRequestExceptionsWhileWalking()
    {
        $client = $this->mockClient([
            $this->page([['id' => 'a']], ['page' => 1, 'per_page' => 1, 'total_pages' => 2]),
            new Response(404, [], json_encode(['success' => false, 'errors' => [['code' => 7003, 'message' => 'Could not route to /zones']]])),
        ]);

        $this->expectException(NotFoundException::class);

        $client->getHttpClient()->paginate('/zones', ['per_page' => 1])->all();
    }

    /**
     * Build a Cloudflare style page response.
     *
     * @param array|null $result
     * @param array|null $info
     * @return Response
     */
    private function page(?array $result, ?array $info = null): Response
    {
        $body = [
            'success' => true,
            'errors' => [],
            'messages' => [],
            'result' => $result,
        ];

        if ($info !== null) {
            $body['result_info'] = $info;
        }

        return new Response(200, [], json_encode($body));
    }

    /**
     * The `page` parameter sent with each request, in order.
     *
     * @return array<int, string|null>
     */
    private function requestedPages(): array
    {
        return $this->requestedParam('page');
    }

    /**
     * The `cursor` parameter sent with each request, in order.
     *
     * @return array<int, string|null>
     */
    private function requestedCursors(): array
    {
        return $this->requestedParam('cursor');
    }

    /**
     * @param string $name
     * @return array<int, string|null>
     */
    private function requestedParam(string $name): array
    {
        return array_map(
            fn (int $index) => $this->queryOf($index)[$name] ?? null,
            array_keys($this->requestHistory)
        );
    }

    /**
     * The parsed query string of the nth request.
     *
     * @param int $index
     * @return array<string, string>
     */
    private function queryOf(int $index): array
    {
        parse_str($this->requestHistory[$index]['request']->getUri()->getQuery(), $query);

        return $query;
    }
}
