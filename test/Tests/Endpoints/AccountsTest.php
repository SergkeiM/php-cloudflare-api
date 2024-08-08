<?php

namespace SergkeiM\CloudFlare\Tests\Endpoints;

use SergkeiM\CloudFlare\Endpoints\Accounts;

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
                ['id' => 'af5f83226fcf7de29daeff6289b5639f', 'name' => 'accountName3', 'type' => 'standard'],
                ['id' => 'af5f83226fcf7de29daeff6289b5635f', 'name' => 'accountName4', 'type' => 'standard'],
            ]
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/accounts')
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->all());
    }

    /**
     * @test
     */
    public function shouldGetAccountDetails()
    {
        $expectedArray = [
            'success' => true,
            'messages' => [],
            'errors' => [],
            'result' => [
                [
                    'id' => 'af5f83226fcf7de29daeff6289b5637f',
                    'name' => 'accountName',
                    'type' => 'standard'
                ]
            ]
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
            'success' => true,
            'messages' => [],
            'errors' => [],
            'result' => [
                [
                    'id' => 'af5f83226fcf7de29daeff6289b5637f',
                    'name' => 'accountName',
                    'type' => 'standard'
                ]
            ]
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('put')
            ->with('/accounts/af5f83226fcf7de29daeff6289b5637f', [
                'success' => true,
                'messages' => [],
                'errors' => [],
                'result' => [
                    [
                        'id' => 'af5f83226fcf7de29daeff6289b5637f',
                        'name' => 'accountName',
                        'type' => 'standard'
                    ]
                ]
            ])
            ->will($this->returnValue($expectedArray));

        $this->assertEquals($expectedArray, $api->update('af5f83226fcf7de29daeff6289b5637f', ['name' => 'test']));
    }
}
