<?php

namespace Tests\HumanDirect\Socially;

use HumanDirect\Socially\Parser;
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

            // supported social media URLs
            ['http://www.facebook.com/profile.php?id=100000640285573', true],
            ['http://github.com/balazscsaba2006', true],
            ['http://github.com/BALAZSCSABA2006', true],
            ['https://www.linkedin.com/in/csaba-balazs-64b65320/', true],
            ['https://ro.linkedin.com/pub/csaba-balazs/20/653/64b', true],
            ['https://www.linkedin.com/company/human-direct-romania/', true],
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
}
