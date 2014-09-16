<?php

use DDM\SmartyStreets\Address as Address;

class AddressTest extends PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $this->address = new Address();
    }

    public function testSetData()
    {
        // arrange
        $expected = array(
            'street'    => '123 abc',
            'street2'   => 'Suite 102',
            'city'      => 'cleveland',
            'state'     => 'ohio',
            'zipcode'   => '12345',
            'secondary' => null,
            'addressee' => null
        );

        // act
        $this->address->setData($expected);
        $actual = $this->address->toArray();

        // assert
        $this->assertEquals($expected, $actual, 'Data not set properly');
    }
}
