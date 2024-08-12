<?php

namespace SergkeiM\CloudFlare\Tests\Endpoints;

use SergkeiM\CloudFlare\Endpoints\Accounts;
use SergkeiM\CloudFlare\HttpClient\Response;

class AccountsTest extends TestCase
{
    /**
     * @return string
     */
    protected function getApiClass()
    {
        return Accounts::class;
    }

    /**
     * @test
     */
    public function shouldGetAllAccounts()
    {
        $expectedArray = [
            'result' => [
                ['id' => 'af5f83226fcf7de29daeff6289b5637f', 'name' => 'accountName1', 'type' => 'standard'],
                ['id' => 'af5f83226fcf7de29daeff6289b5638f', 'name' => 'accountName2', 'type' => 'enterprise'],
            ],
            'result_info' => [
                "page" => 1,
                "per_page" => 20,
                "count" => 20,
                "total_pages" => 40,
                "total_count" => 795,
            ],
        ];

        $response = $this->getResponseMock();
        $paginator = $this->getPaginatorMock(1, 20, [], fn () => null);

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/accounts')
            ->will($this->returnValue(new Response($response)));

        $this->assertEquals($paginator, $api->all());
    }

    /**
     * @test
     */
    public function shouldGetAccountDetails()
    {
        $expectedArray = [
            'result' => [
                [
                    'id' => 'af5f83226fcf7de29daeff6289b5637f',
                    'name' => 'accountName',
                    'type' => 'standard',
                ],
            ],
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/accounts/af5f83226fcf7de29daeff6289b5637f')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->details('af5f83226fcf7de29daeff6289b5637f'));
    }

    public function shouldUpdateAccount()
    {
        $expectedArray = [
            'result' => [
                [
                    'id' => 'af5f83226fcf7de29daeff6289b5637f',
                    'name' => 'accountName',
                    'type' => 'standard',
                ],
            ],
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('put')
            ->with('/accounts/af5f83226fcf7de29daeff6289b5637f', [
                'result' => [
                    [
                        'id' => 'af5f83226fcf7de29daeff6289b5637f',
                        'name' => 'accountName',
                        'type' => 'standard',
                    ],
                ],
            ])
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->update('af5f83226fcf7de29daeff6289b5637f', ['name' => 'test']));
    }
}
