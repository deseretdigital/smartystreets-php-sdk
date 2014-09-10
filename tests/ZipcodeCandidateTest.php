<?php

use DDM\SmartyStreets\ZipcodeCandidate as Candidate;

class ZipcodeCandidateTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->candidate = new Candidate();
        $responseJson = $this->getValidResponseJson();
        $this->candidate->setFromObject(json_decode($responseJson)[0]);
    }

    public function testGetAddress()
    {
        // arrange
        $expected = array(
            'city'      => 'Los Angeles',
            'state'     => 'CA',
            'zipcode'   => '90230'
        );

        // act
        $actual = $this->candidate->getAddress()->toArray();

        // assert
        $this->assertEquals($expected, $actual, 'These should match');
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
        }]';

        return $responseJson;
    }
}