<?php

namespace litemerafrukt\Either;

/**
 * Tests
 *
 */
class EitherTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Basic test to create class.
     */
    public function testCreateHello()
    {
        $hello = new Right("");
        $this->assertInstanceOf(Right::class, $hello);
    }

    //
    //
    // /**
    //  * Test hello
    //  */
    // public function testUri()
    // {
    //     $hello = new Hello();
    //     $this->assertEquals("Hello World!", $hello->hello(), "Hello method did not say hello world");
    // }
}
