<?php

use DDM\SmartyStreets\ValidatedZipcode;

class ValidatedZipcodeTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->validatedZipcode = new ValidatedZipcode();

    }

    public function testSetData()
    {
        // arrange
        $expected = array(
            'address'           => null,
            'city'              => 'Los Angeles',
            'state'             => 'California',
            'stateAbbreviation' => 'CA',
            'candidates'        => array()
        );

        // act
        $actual = $this->validatedZipcode->setData($expected)->toArray();

        // assert
        $this->assertEquals($expected, $actual, 'These should match');
    }

    // public function testSetFromObject()
    // {
    //     // arrange
    //     $responseJson = $this->getValidResponseJson();
    //     $response = json_decode($responseJson);

    //     $expected = array(
    //         'zipcode'     => '90230',
    //         'zipcodeType' => 'S',
    //         'countyFips'  => '06037',
    //         'countyName'  => 'Los Angeles',
    //         'latitude'    => 33.996155,
    //         'longitude'   => -118.395494
    //     );

    //     $this->candidate->setBody($)

    //     // act

    //     $this->candidate->setFromObject($response);
    //     $actual = $this->candidate->toArray();

    //     // assert
    //     $this->assertEquals($expected, $actual, 'Properties not set correctly');
    // }

    // protected function getValidResponseJson()
    // {
    //     $responseJsonPartial = '
    //     {
    //         "zipcode": "90230",
    //         "zipcode_type": "S",
    //         "county_fips": "06037",
    //         "county_name": "Los Angeles",
    //         "latitude": 33.996155,
    //         "longitude": -118.395494
    //     }';

    //     return $responseJsonPartial;
    // }
}
