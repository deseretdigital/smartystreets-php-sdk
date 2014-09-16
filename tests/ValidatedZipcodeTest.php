<?php

use DDM\SmartyStreets\ValidatedZipcode;
use DDM\SmartyStreets\ZipcodeCandidate;

class ValidatedZipcodeTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->validatedZipcode = new ValidatedZipcode();
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

    public function testHasCandidates()
    {
        // arrange
        $zipcodeCandidateMock = Mockery::mock('\\DDM\\SmartyStreets\\ZipcodeCandidate');


        // act
        $shouldBeFalse = $this->validatedZipcode->hasCandidates();

        $this->validatedZipcode->setCandidates(array($zipcodeCandidateMock));

        $shouldBeTrue = $this->validatedZipcode->hasCandidates();

        // assert
        $this->assertFalse($shouldBeFalse, 'There shouldn\'t be any candidates' );
        $this->assertTrue($shouldBeTrue, 'We should have one cadidate');
    }
}
