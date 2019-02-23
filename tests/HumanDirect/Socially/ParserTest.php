<?php

namespace Tests\HumanDirect\Socially;

use HumanDirect\Socially\Parser;
use HumanDirect\Socially\Result;
use PHPUnit\Framework\TestCase;

/**
 * Class ParserTest.
 */
class ParserTest extends TestCase
{
    /**
     * @var Parser
     */
    private $parser;

    /**
     * Set up test.
     */
    public function setUp()
    {
        $this->parser = new Parser();
    }

    /**
     * @dataProvider getValidParseUrls
     *
     * @param string $url
     * @param Result $expected
     */
    public function testValidParse(string $url, Result $expected): void
    {
        $result = $this->parser->parse($url);
        $this->assertEquals($expected, $result);
    }

    /**
     * @return array
     */
    public function getValidParseUrls(): array
    {
        return [
            ['http://www.facebook.com/profile.php?id=100000640285573', Result::create('www', 'facebook', 'com')],
            ['http://github.com/balazscsaba2006', Result::create(null, 'github', 'com')],
            ['https://ro.linkedin.com/pub/csaba-balazs/20/653/64b', Result::create('ro', 'linkedin', 'com')],
            ['https://plus.google.com/106924247729881790951/about', Result::create('plus', 'google', 'com')],
            ['http://careers.stackoverflow.com/balazscsaba2006', Result::create('careers', 'stackoverflow', 'com')],
        ];
    }

    /**
     * @dataProvider getInvalidParseUrls
     * @expectedException \HumanDirect\Socially\NotSupportedException
     *
     * @param string $url
     */
    public function testInvalidParse(string $url): void
    {
        $this->parser->parse($url);
    }

    /**
     * @return array
     */
    public function getInvalidParseUrls(): array
    {
        return [
            // invalid URLs
            [''],
            ['127.0.0.1'],
            ['::1'],

            // not supported social media URLs
            ['https://subdomain.wordpress.com'],
        ];
    }

    /**
     * @dataProvider getIsSocialMediaProfileUrls
     *
     * @param string $url
     * @param bool   $expected
     */
    public function testIsSocialMediaProfile(string $url, bool $expected): void
    {
        $result = $this->parser->isSocialMediaProfile($url);
        $this->assertEquals($expected, $result);
    }

    /**
     * @return array
     */
    public function getIsSocialMediaProfileUrls(): array
    {
        return [
            // invalid URLs
            ['', false],
            ['127.0.0.1', false],
            ['::1', false],

            // not supported social media URLs
            ['https://subdomain.wordpress.com', false],
            ['https://www.linkedin.com/company/human-direct-romania/', false],

            // supported social media URLs
            ['http://www.facebook.com/profile.php?id=100000640285573', true],
            ['http://github.com/balazscsaba2006', true],
            ['http://github.com/BALAZSCSABA2006', true],
            ['https://www.linkedin.com/in/csaba-balazs-64b65320/', true],
            ['https://ro.linkedin.com/pub/csaba-balazs/20/653/64b', true],
            ['https://www.linkedin.com/profile/view?id=144743673', true],
            ['https://twitter.com/HumanDirectEU', true],
            ['https://angel.co/balazscsaba2006/', true],
            ['http://en.gravatar.com/balazscsaba2006', true],
            ['http://klout.com/balazs_csaba2006', true],
            ['http://klout.com/user/id/447263752102886632', true],
            ['http://www.pinterest.com/balazscsaba2006/', true],
            ['http://behance.net/balazs-csaba_2006', true],
            ['https://bitbucket.org/balazscsaba2006/', true],
            ['http://www.dribbble.com/balazscsaba2006', true],
            ['http://www.flickr.com/people/28125134@n02', true],
            ['https://plus.google.com/106924247729881790951/about', true],
            ['https://plus.google.com/u/0/+csaba.balazs', true],
            ['https://stackoverflow.com/users/509414/balazscsaba2006', true],
            ['http://careers.stackoverflow.com/balazscsaba2006', true],
            ['http://www.reddit.com/user/balazscsaba2006', true],
            ['http://www.quora.com/profile/balazscsaba-2006', true],
            ['http://www.quora.com/balazscsaba-2006', true],
        ];
    }

    /**
     * @dataProvider getIdentifyPlatformUrls
     *
     * @param string $url
     * @param string $expected
     */
    public function testIdentifyPlatform(string $url, string $expected): void
    {
        $platform = $this->parser->identifyPlatform($url);
        $this->assertEquals($expected, $platform);
    }

    /**
     * @return array
     */
    public function getIdentifyPlatformUrls(): array
    {
        return [
            ['http://www.facebook.com/profile.php?id=100000640285573', 'facebook'],
            ['https://www.linkedin.com/in/csaba-balazs-64b65320/', 'linkedin'],
            ['https://plus.google.com/106924247729881790951/about', 'google_plus'],
            ['https://stackoverflow.com/users/509414/balazscsaba2006', 'stackoverflow'],
            ['http://careers.stackoverflow.com/balazscsaba2006', 'stackoverflow.careers'],
        ];
    }

    /**
     * @dataProvider getNormalizeUrls
     *
     * @param string $url
     * @param string $expected
     */
    public function testNormalize(string $url, string $expected): void
    {
        $result = $this->parser->normalize($url);
        $this->assertEquals($expected, $result);
    }

    /**
     * @return array
     */
    public function getNormalizeUrls(): array
    {
        return [
            ['http://www.FACEBOOK.com/profile.php?id=100000640285573/', 'https://facebook.com/profile.php?id=100000640285573'],
            ['https://www.linkedin.com/in/csaba-balazs-64b65320/', 'https://linkedin.com/in/csaba-balazs-64b65320'],
            ['https://plus.google.com/106924247729881790951/ABOUT', 'https://plus.google.com/106924247729881790951/about'],
            ['https://stackoverflow.com/users/509414/balazscsaba2006', 'https://stackoverflow.com/users/509414/balazscsaba2006'],
            ['http://careers.stackoverflow.com/balazscsaba2006/', 'https://careers.stackoverflow.com/balazscsaba2006'],
            ['http://some-unsupported-platform.com/', 'http://some-unsupported-platform.com/'],
            ['https://ro.linkedin.com/pub/ciprian-cetera%C8%99/53/24b/481', 'https://linkedin.com/pub/ciprian-ceteraș/53/24b/481'],
            ['https://ro.linkedin.com/pub/ciprian-ceteraș/53/24b/481', 'https://linkedin.com/pub/ciprian-ceteraș/53/24b/481'],
            ['https://ro.linkedin.com/in/ciprian-ceteraș/', 'https://linkedin.com/in/ciprian-ceteraș'],
        ];
    }
}
