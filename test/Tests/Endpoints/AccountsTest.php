<?php

namespace CloudFlare\Tests\Endpoints;

use CloudFlare\Endpoints\Accounts;

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
                ['id' => 'identifier1', 'name' => 'accountName1', 'type' => 'standard'],
                ['id' => 'identifier2', 'name' => 'accountName2', 'type' => 'enterprise'],
            ],
            'result_info' => [
                "page" => 1,
                "per_page" => 20,
                "count" => 20,
                "total_pages" => 2,
                "total_count" => 40,
            ],
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('sendGet')
            ->with('/accounts')
            ->will($this->returnValue($this->getResponseMock($expectedArray)));

        $this->assertEquals($expectedArray, $api->all()->toArray());
    }

    /**
     * @test
     */
    public function shouldGetAccountDetails()
    {
        $expectedArray = [
            'result' => [
                [
                    'id' => 'identifier1',
                    'name' => 'accountName',
                    'type' => 'standard',
                ],
            ],
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('sendGet')
            ->with('/accounts/identifier1')
            ->will($this->returnValue($this->getResponseMock($expectedArray)));

        $this->assertEquals($expectedArray, $api->details('identifier1')->toArray());
    }

    public function shouldUpdateAccount()
    {
        $expectedArray = [
            'result' => [
                [
                    'id' => 'identifier1',
                    'name' => 'accountName',
                    'type' => 'standard',
                ],
            ],
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('sendPut')
            ->with('/accounts/identifier1', [
                'result' => [
                    [
                        'id' => 'identifier1',
                        'name' => 'accountName',
                        'type' => 'standard',
                    ],
                ],
            ])
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->update('identifier1', ['name' => 'test']));
    }
}
