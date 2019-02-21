<?php

namespace Tests\HumanDirect\Socially;

use PHPUnit\Framework\TestCase;

/**
 * Class StaticTest.
 */
class StaticTest extends TestCase
{
    /**
     * @dataProvider getIsSocialMediaProfileUrls
     *
     * @param string $url
     * @param bool   $expected
     */
    public function testSociallyIsSocialMediaProfile(string $url, bool $expected): void
    {
        $result = socially_isSocialMediaProfile($url);
        $this->assertEquals($expected, $result);
    }

    /**
     * @return array
     */
    public function getIsSocialMediaProfileUrls(): array
    {
        // use the exact same provider as for the ParserTest
        return call_user_func([ParserTest::class, 'getIsSocialMediaProfileUrls']);
    }
}
