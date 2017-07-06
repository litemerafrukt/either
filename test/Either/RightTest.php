<?php

namespace litemerafrukt\Either;

use \PHPUnit\Framework\TestCase;

/**
 * Test cases for Left
 */

class RightTest extends TestCase
{
    /**
     * Test creation
     */
    public function testCreateRight()
    {
         $right = new Right(42);
         $this->assertInstanceOf(Right::class, $right);
    }

    /**
     * Test isRight
     */
    public function testIsRight()
    {
        $right = new Right(42);
        $this->assertEquals(true, $right->isRight());
    }

    /**
     * Test isLeft
     */
    public function testIsLeft()
    {
        $right = new Right(42);
        $this->assertEquals(false, $right->isLeft());
    }

    /**
     * Test get
     *
     * Get function is a php convenience function
     */
    public function testGet()
    {
        $right = new Right(42);
        $this->assertEquals(42, $right->get());
    }

    /**
     * Test orElse
     *
     * orElse should return same objekt since we are right
     */
    public function testOrElse()
    {
        $right = new Right(42);
        $orElseLeft = new Left('orElse Left');

        $resultingEither = $right->orElse($orElseLeft);

        $this->assertSame($right, $resultingEither);
    }

    /**
     * Test filter
     *
     * The filter method should return right if filterFunction
     * evaluates to true and left if filterFunction evaluates to false.
     */
    public function testFilter()
    {
        $right = new Right(42);

        $rightResult = $right->filter(function ($value) {
            return $value === 42;
        }, 'This error should be ignored');

        $this->assertSame($right, $rightResult);
        $this->assertEquals(42, $rightResult->get());

        $leftResult = $right->filter(function ($value) {
            return $value !== 42;
        }, 'You know... 42 is not the answer to everything, really.');

        $this->assertNotSame($right, $leftResult);
        $this->assertEquals(
            'You know... 42 is not the answer to everything, really.',
            $leftResult->get()
        );

        // Original right should be unchanged
        $this->assertEquals(42, $right->get());
    }

    /**
     * Test map
     *
     * Map over a right changes the value within
     */
    public function testMap()
    {
        $right = new Right(32);

        $resultingRight = $right->map(function ($value) {
            return $value + 10;
        });

        $this->assertEquals(42, $resultingRight->get());

        // Original right should be unchanged
        $this->assertNotSame($right, $resultingRight);
        $this->assertEquals(32, $right->get());
    }

    /**
     * Test withDefault
     *
     * withDefault method is a safe way to get a value from an Either.
     * A Right should ignore the value in withDefault.
     */
    public function testWithDefault()
    {
        $right = new Right(42);

        $value = $right->withDefault('This is not the answer');

        $this->assertEquals(42, $value);
    }

    /**
     * Test resolve
     *
     * Resolve metod is a function to decide where to go depending on if
     * the Either is a Right or a Left.
     */
    public function testResolve()
    {
        $right = new Right(42);

        $resolveResult = $right->resolve(
            function ($value) {
                return "The answer has always been $value.";
            },
            function ($errorMsg) {
                return "This error message, $errorMsg, should be ignored.";
            }
        );

        $this->assertEquals(
            "The answer has always been 42.",
            $resolveResult
        );
    }
}
