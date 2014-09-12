<?php

use DDM\SmartyStreets\ZipcodeValidationResponse as ZipcodeResponse;

class ZipcodeValidationResponseTest extends PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $this->response = new ZipcodeResponse();
    }

    /**
    * Tears down the fixture, for example, closes a network connection.
    * This method is called after a test is executed.
    */
    protected function tearDown()
    {
        \Mockery::close();
    }

    public function testSetData()
    {
        // arrange
        $expected = array(
            'city'               => 'Los Angeles',
            'state'              => 'California',
            'stateAbbreviation'  => 'CA',
            'candidates'         => null,
            'body'               => 'test body 123',
            'addresses'          => array()
        );

        // act
        $this->response->setData($expected);
        $actual = $this->response->toArray();

        // assert
        $this->assertEquals($expected, $actual, 'Data not set properly');
    }

    public function testSetFromObject()
    {
        // arrange
        $responseJson = $this->getValidResponseJson();
        $response = json_decode($responseJson);

        $expectedZipcode = array(
            'inputIndex'  => 0,
            'zipcode'     => '90230',
            'zipcodeType' => 'S',
            'countyFips'  => '06037',
            'countyName'  => 'Los Angeles',
            'latitude'    => 33.996155,
            'longitude'   => -118.395494
        );

        $expected = array(
            'city'               => 'Los Angeles',
            'state'              => 'California',
            'stateAbbreviation'  => 'CA',
            'candidates'         => array($expectedZipcode),
            'body'               => '',
            'addresses'          => array()
        );

        // act
        $this->response->setFromObject($response);
        $actual = $this->response->toArray();

        // assert
        $this->assertEquals($expected, $actual, 'Properties not set correctly');
    }

    public function testIsValid()
    {
        // arrange
        $mockZipCandidate = Mockery::mock('\\DDM\\SmartyStreets\\ZipcodeCandidate');

        // act
        $isValidFalse = $this->response->isValid();

        $this->response->setCandidates(array($mockZipCandidate));
        $isValidTrue = $this->response->isValid();

        // assert
        $this->assertFalse($isValidFalse, 'Response should not be valid');
        $this->assertTrue($isValidTrue, 'Response should be valid');

    }

    public function testHasCandidates()
    {
        // arrange
        $mockZipCandidate = Mockery::mock('\\DDM\\SmartyStreets\\ZipcodeCandidate');

        // act
        $isValidFalse = $this->response->hasCandidates();

        $this->response->setCandidates(array($mockZipCandidate));
        $isValidTrue = $this->response->hasCandidates();

        // assert
        $this->assertFalse($isValidFalse, 'Response should not be valid');
        $this->assertTrue($isValidTrue, 'Response should be valid');

    }

    public function testGetCandidates()
    {
        // arrange
        $mockZipCandidate = Mockery::mock('\\DDM\\SmartyStreets\\ZipcodeCandidate');

        $expected = array(
            $mockZipCandidate
        );

        $this->response->setCandidates($expected);

        // act
        $actual = $this->response->getCandidates();

        // assert
        $this->assertEquals($expected, $actual, 'Failed to retrieve candidates');
    }

    public function testGetValidatedZipcodes()
    {
        // arrange
        $responseJson = $this->getValidResponseJson();
        $response = json_decode($responseJson);
        $this->response->setFromObject($response);

        $addressData = array(
            'street'    => null,
            'street2'   => null,
            'city'      => 'Los Angeles',
            'state'     => 'CA',
            'zipcode'   => '90230',
            'secondary' => null,
            'addressee' => null
        );

        $addressMock = Mockery::mock('\\DDM\\SmartyStreets\\Address');
        $addressMock->shouldReceive('toArray')->andReturn($addressData);

        $this->response->setAddresses(array($addressMock));

        $expected = array(
            'address' => $addressData,

            'city'              => 'Los Angeles',
            'state'             => 'California',
            'stateAbbreviation' => 'CA',
            'candidates' => array(
                array(
                    'inputIndex'  => 0,
                    'zipcode'     => '90230',
                    'zipcodeType' => 'S',
                    'countyFips'  => '06037',
                    'countyName'  => 'Los Angeles',
                    'latitude'    => 33.996155,
                    'longitude'   => -118.395494
                )
            )
        );

        // act
        $validatedZipcodes = $this->response->getValidatedZipcodes();

        sd($validatedZipcodes);

        $actual = $validatedZipcodes[0]->toArray();

        // assert
        $this->assertEquals($expected, $actual, 'Address not extracted properly');

    }

    protected function getValidResponseJson()
    {
        $responseJson = '[
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

        return $responseJson;
    }
}
