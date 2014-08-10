<?php

use DDM\Api\SmartyStreets\SmartyStreetsClient;

class MessageTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var SmartStreetsClient
     */
    protected $client;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->client = new SmartyStreetsClient();
    }

    /*
     * Test client instantiation
     */
    public function testClientSetup()
    {
        // Arrange
        $expectedConfig = array(
            'baseUri'   => 'https://api.smartystreets.com/',
            'authId'    => '123',
            'authToken' => '321'
        );

        $this->client->setConfig($config);

        // Act
        $actualConfig = $this->client->getConfig();

        // Assert
        $this->assertEquals($expectedConfig, $actualConfig);
    }

}


