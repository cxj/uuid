<?php
require '../src/Uuid.php';

use Cxj\Uuid;

class UuidTest extends \PHPUnit_Framework_TestCase
{
    public function testIsValid()
    {
        $this->assertTrue(
            Uuid::is_valid('1546058f-5a25-4334-85ae-e68f2a44bbaf'),
            'Valid UUID wrongly flagged as invalid.'
        );
    }

    public function testIsNotValid()
    {
        $this->assertFalse(
            Uuid::is_valid('12345678-1234-1234-1234-1234isnothex'),
            'Invalid UUID wrongly flagged as valid.'
        );
    }

    public function testCanGenerateV4()
    {
        $v4 = Uuid::v4();

        $this->assertStringMatchesFormat(
            '%x-%x-%x-%x-%x',
            $v4,
            'Improper output format.'
        );

        // Should be valid, and is_valid() should be correct from above tests.
        $this->assertTrue(Uuid::is_valid($v4), 'Generated UUID not valid.');
    }

    public function testCanGenerateV5()
    {
        $namespaceUuid = '6ba7b810-9dad-11d1-80b4-00c04fd430c8'; // RFC4122 DNS
        $name = 'www.example.com';

        $v5 = Uuid::v5($namespaceUuid, $name);

        $this->assertStringMatchesFormat(
            '%x-%x-%x-%x-%x',
            $v5,
            'Improper output format.'
        );

        $this->assertTrue(Uuid::is_valid($v5), 'Generated UUID not valid.');
    }

    public function testRepeatableV5()
    {
        $namespaceUuid = '6ba7b810-9dad-11d1-80b4-00c04fd430c8'; // RFC4122 DNS
        $name = 'www.example.com';

        $v5 = Uuid::v5($namespaceUuid, $name);

        $v52 = Uuid::v5($namespaceUuid, $name);

        $this->assertEquals($v5, $v52, 'V5 UUIDs should be the same, but are not.');
    }
}
