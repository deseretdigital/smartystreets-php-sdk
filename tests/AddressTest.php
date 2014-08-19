<?php

use DDM\SmartyStreets\Address as Address;

class AddressTest extends PHPUnit_Framework_TestCase
{
  public function testAddress()
  {
    $addressArray = [
        'street' => '123 abc',
        'city'   => 'cleveland',
        'state'  => 'ohio',
        'zipcode'    => '12345',
    ];

    $address = new Address($addressArray);
    $result = $address->toArray();
    $this->assertEmpty(array_diff_assoc($addressArray, $result), 'should be empty');
  }

}
