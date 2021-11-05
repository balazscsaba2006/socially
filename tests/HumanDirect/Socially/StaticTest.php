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
     */
    public function testSociallyIsSocialMediaProfile(string $url, bool $expected): void
    {
        $result = socially_isSocialMediaProfile($url);
        $this->assertEquals($expected, $result);
    }

    /**
     * @return iterable<string, bool>
     */
    public function getIsSocialMediaProfileUrls(): iterable
    {
        // use the exact same provider as for the ParserTest
        return call_user_func([new ParserTest(), 'getIsSocialMediaProfileUrls']);
    }

    /**
     * @dataProvider getNormalizeUrls
     */
    public function testSociallyNormalize(string $url, string $expected): void
    {
        $result = socially_normalize($url);
        $this->assertEquals($expected, $result);
    }

    /**
     * @return iterable<string, string>
     */
    public function getNormalizeUrls(): iterable
    {
        // use the exact same provider as for the ParserTest
        return call_user_func([new ParserTest(), 'getNormalizeUrls']);
    }
}
