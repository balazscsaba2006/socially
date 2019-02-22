<?php

namespace Tests\HumanDirect\Socially;

use HumanDirect\Socially\Util;
use PHPUnit\Framework\TestCase;

/**
 * Class UtilTest
 */
class UtilTest extends TestCase
{
    /**
     * @return void
     */
    public function testToCamelCase(): void
    {
        static::assertEquals('Platform', Util::toCamelCase('platform'));
        static::assertEquals('PlatformSuffix', Util::toCamelCase('platform.suffix'));
        static::assertEquals('GooglePlus', Util::toCamelCase('google.plus'));
        static::assertEquals('GooglePlus', Util::toCamelCase('google-plus'));
        static::assertEquals('GooglePlus', Util::toCamelCase('google_plus'));
        static::assertEquals('', Util::toCamelCase(''));
    }

    /**
     * @return void
     */
    public function testIsValidUrl(): void
    {
        static::assertEquals(false, Util::isValidUrl(''));
        static::assertEquals(true, Util::isValidUrl('  http://github.com/BALAZSCSABA2006/ '));
    }

    /**
     * @return void
     */
    public function testCleanUrl(): void
    {
        static::assertEquals('', Util::cleanUrl(''));
        static::assertEquals('http://github.com/balazscsaba2006/', Util::cleanUrl('  http://github.com/BALAZSCSABA2006/ '));
    }
}
