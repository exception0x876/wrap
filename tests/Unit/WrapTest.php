<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

use function Wrap\wrap;

class WrapTest extends TestCase
{
    public function testLongStringWrap()
    {
        $string = \str_repeat('a', 15);
        $expected = "aaaaa\naaaaa\naaaaa";
        $this->assertEquals($expected, wrap($string, 5));
    }

    public function testMultipleSpacesRemoval()
    {
        $string = 'The quick brown    fox jumps over the lazy dog';
        $expected = "The quick brown\nfox jumps over\nthe lazy dog";
        $this->assertEquals($expected, wrap($string, 15));
    }

    public function testUnbrokenWhitespaceRemaining()
    {
        $string = ' The quick brown    fox jumps over the lazy dog ';
        $expected = " The quick brown    fox\njumps over the lazy dog\n";
        $this->assertEquals($expected, wrap($string, 23));
    }

    public function testExistingNewlinesRemaining()
    {
        $string = " The quick brown    fox jumps\r\n over \n\nthe lazy dog";
        $expected = " The quick\nbrown    fox\njumps\n over\n\nthe lazy dog";
        $this->assertEquals($expected, wrap($string, 15));
    }
}
