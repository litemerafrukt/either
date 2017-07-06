<?php

namespace litemerafrukt\Either;

use \PHPUnit\Framework\TestCase;

/**
 * Test cases for Left
 */

class LeftTest extends TestCase
{
    /**
     * Test creation
     */
    public function testCreateLeft()
    {
         $left = new Left('Error message');
         $this->assertInstanceOf(Left::class, $left);
    }

    /**
     * Test isLeft
     */
    public function testIsLeft()
    {
        $left = new Left('Error message');
        $this->assertEquals(true, $left->isLeft());
    }

    /**
     * Test isRight
     */
    public function testIsRight()
    {
        $left = new Left('Error message');
        $this->assertEquals(false, $left->isRight());
    }

    /**
     * Test get
     *
     * Get function is a php convenience function
     */
    public function testGet()
    {
        $left = new Left('Error message');
        $this->assertEquals('Error message', $left->get());
    }

    /**
     * Test orElse
     *
     * orElse should return else since Left is "error" branch
     */
    public function testOrElse()
    {
        $left = new Left('Original Left');
        $orElseLeft = new Left('orElse Left');

        $resultingLeft = $left->orElse($orElseLeft);

        $this->assertSame($orElseLeft, $resultingLeft);
    }

    /**
     * Test filter
     *
     * The filter method should just return the Left since
     * we already is on the "error" branch.
     */
    public function testFilter()
    {
        $left = new Left('Error message');

        $resultingLeft = $left->filter(function ($_) {
            return true;
        }, "Original error message should be preserved");

        $this->assertSame($left, $resultingLeft);
        $this->assertEquals('Error message', $resultingLeft->get());
    }

    /**
     * Test map
     *
     * Map over a left should not modify anything, just return same.
     */
    public function testMap()
    {
        $left = new Left('Error message');

        $resultingLeft = $left->map(function ($_) {
            return "This value is ignored";
        });

        $this->assertSame($left, $resultingLeft);
        $this->assertEquals('Error message', $resultingLeft->get());
    }

    /**
     * Test withDefault
     *
     * withDefault method is a safe way to get a value from an Either.
     * A Left should return the value passed to withDefault.
     */
    public function testWithDefault()
    {
        $left = new Left('Error message');

        $value = $left->withDefault('Valid value');

        $this->assertEquals('Valid value', $value);
    }

    /**
     * Test resolve
     *
     * Resolve metod is a function to decide where to go depending on if
     * the Either is a Right or a Left.
     */
    public function testResolve()
    {
        $left = new Left('Error message');

        $resolveResult = $left->resolve(
            function ($_) {
                return "This is Right resolve function and will be ignored";
            },
            function ($errorMsg) {
                return "This is Left resolve function with value = '$errorMsg'";
            }
        );

        $this->assertEquals(
            "This is Left resolve function with value = 'Error message'",
            $resolveResult
        );
    }
}
