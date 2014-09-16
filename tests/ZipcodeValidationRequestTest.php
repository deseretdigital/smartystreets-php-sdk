<?php

use DDM\SmartyStreets\Address;
use DDM\SmartyStreets\ZipcodeValidationRequest;
use Guzzle\Http\Client as GuzzleClient;
use Guzzle\Http\Message\Response;
use Guzzle\Http\Stream\Stream;


class ZipcodeValidationRequestTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $this->guzzleClientMock = \Mockery::mock('\\Guzzle\\HTTP\\Client');
        $this->guzzleRequestMock = \Mockery::mock('\\Guzzle\\Http\\Message\\Request');
        $this->guzzleResponseMock = \Mockery::mock('\\Guzzle\\Http\\Message\\Response');

        $this->smartyRequest = new ZipcodeValidationRequest('','', $this->guzzleClientMock);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        \Mockery::close();
    }

    public function testDefaultClient()
    {
        $smartyRequest = new ZipcodeValidationRequest('','');
        $client = $smartyRequest->getClient();

        $this->assertTrue($client instanceof GuzzleClient);
    }

    public function testSetClient()
    {
        $guzzleClient = $this->guzzleClientMock;

        $smartyRequest = $this->smartyRequest;
        $smartyRequest->setClient($guzzleClient);

        $this->assertEquals($guzzleClient, $smartyRequest->getClient());
    }

    public function testAddAddress()
    {
        $smartyRequest = $this->smartyRequest;
        $address = new Address(array());

        $smartyRequest->addAddress($address);
        $addressCount = count($smartyRequest->getAddresses());

        $this->assertEquals(1, $addressCount, 'should have exactly one address');
    }

    public function testValidateAddress()
    {
        // arrange

        $smartyRequest = $this->smartyRequest;
        $guzzleClient = $this->guzzleClientMock;
        $guzzleRequest = $this->guzzleRequestMock;
        $guzzleResponse = $this->guzzleResponseMock;

        $rawResponse = '[
            {
                "input_index": 0,
                "city_states": [
                    {
                        "city": "Los Angeles",
                        "state_abbreviation": "CA",
                        "state": "California"
                    }
                ],
                "zipcodes": [
                    {
                        "zipcode": "90230",
                        "zipcode_type": "S",
                        "county_fips": "06037",
                        "county_name": "Los Angeles",
                        "latitude": 33.996155,
                        "longitude": -118.395494
                    }
                ]
            }
            ]';


        $guzzleResponse->shouldReceive('getBody')->once()
          ->andReturn($rawResponse);

        $guzzleRequest->shouldReceive('send')->once()
          ->andReturn($guzzleResponse);

        $guzzleClient->shouldReceive('post')->once()
          ->andReturn($guzzleRequest);

        // act
        $addressArray = json_decode(
      	  '{
        	 	"addressee": "Apple Inc",
        		"street": "1 infinite loop",
        		"street2": "po box 42",
        		"city": "cupertino",
        		"state": "ca",
        		"zipcode": "95014",
    	      "candidates": 10
    	    }',true
        );
        $address = new Address($addressArray);

        $smartyRequest->addAddress($address);
        $validatedZipcodeResponse = $smartyRequest->validateAddresses();

        // assert
        $this->assertTrue($validatedZipcodeResponse->isValid(), 'response should be valid');
    }

    public function testGetZipcodeFields()
    {
        // arrange
        $expected = array(
            'city'      => 'cupertino',
            'state'     => 'ca',
            'zipcode'   => '95014',
        );

        $addressData = array(
            'addressee' => 'Apple Inc',
            'street'    => '1 infinite loop',
            'zipcode'   => '95014',
            'secondary' => null
        );

        $addressData += $expected;

        $addressMock = Mockery::mock('\\DDM\\SmartyStreets\\Address');
        $addressMock->shouldReceive('toArray')->andReturn($addressData);

        // act
        $actual = $this->smartyRequest->getZipcodeFields($addressMock);

        // assert
        $this->assertEquals($expected, $actual, 'Did not receive expected zipcode fields');
    }

}
