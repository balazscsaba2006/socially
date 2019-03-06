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

            // supported social media URLs
            ['https://www.linkedin.com/company/human-direct-romania/', true],
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
            //['https://facebook.com/sharer.php', false],
            //['https://twitter.com/share', false],
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
            ['http://www.facebook.com/people/_/100000049946330', 'https://facebook.com/people/_/100000049946330'],
            ['http://www.facebook.com/profile.php?id=1294422029', 'https://facebook.com/profile.php?id=1294422029'],
            ['http://www.fb.com/profile.php?id=1294422029', 'https://facebook.com/profile.php?id=1294422029'],
            ['https://www.linkedin.com/in/csaba-balazs-64b65320/?lipi=urn%3Ali%3Apage%3Ad_flagship3_search_srp_people%3BPx2eriH%2FSVuZyi9fl7ipiA%3D%3D&licu=urn%3Ali%3Acontrol%3Ad_flagship3_search_srp_people-search_srp_result#some-fragment', 'https://linkedin.com/in/csaba-balazs-64b65320/'],
            ['https://www.linkedin.com/profile/view?id=202583639', 'https://linkedin.com/profile/view?id=202583639'],

            ['http://www.twitter.com/codeschool/dasd?dsadasd', 'https://twitter.com/codeschool/dasd'],
            ['https://www.twitter.com/codeschool?dasdad', 'https://twitter.com/codeschool'],
            ['https://www.twitter.com/Codeschool?dasdad', 'https://twitter.com/codeschool'],
            ['https://twitter.com/codeschool?dasdad', 'https://twitter.com/codeschool'],
            ['https://twitter.com/#!/HumanDirectEU?dasdad', 'https://twitter.com/humandirecteu'],
            ['https://twitter.com/@HumanDirectEU?dasdad', 'https://twitter.com/humandirecteu'],
            ['https://twitter.com/code_school', 'https://twitter.com/code_school'],
            ['https://twitter.com/greentextbooks#', 'https://twitter.com/greentextbooks'],
            ['https://twitter.com/shopbop#cs=ov=73421773243,os=1,link=footerconnecttwitterlink\',', 'https://twitter.com/shopbop'],
            ['https://twitter.com/share', 'https://twitter.com'],
//
            ['https://www.facebook.com/dizzain/?pnref=lhc', 'https://facebook.com/dizzain'],
            ['http://www.facebook.com/dizzain?pnref=lhc', 'https://facebook.com/dizzain'],
            ['http://facebook.com/dizzain?pnref=lhc', 'https://facebook.com/dizzain'],
            ['https://facebook.com/dizzain?pnref=lhc', 'https://facebook.com/dizzain'],
            ['https://facebook.com/Dizzain?pnref=lhc', 'https://facebook.com/dizzain'],
            ['https://www.facebook.com/pages/fasdfadsfasdfsadf/126287147568059?pnref=lhc', 'https://facebook.com/pages/fasdfadsfasdfsadf/126287147568059'],
            ['https://www.facebook.com/PHPtoday-1025912177431644/?fref=ts', 'https://facebook.com/phptoday-1025912177431644'],
            ['http://www.facebook.com/pages/The-bloomtrigger-project/125218650866978/path?asdas', 'https://facebook.com/pages/the-bloomtrigger-project/125218650866978/path'],
            ['http://www.facebook.com/pages/DealMarket/157833714232772', 'https://facebook.com/pages/dealmarket/157833714232772'],
            // not a valid usage ['http://www.facebook.com/#!/pages/dealmarket/157833714232772', 'https://facebook.com/pages/dealmarket/157833714232772'],
            // not a valid usage ['http://www.facebook.com/home.php?tests#!/pages/dealmarket/157833714232772', 'https://facebook.com/pages/dealmarket/157833714232772'],
            ['http://www.facebook.com/pages/san-diego-ca/layer3-security-services/207635209271099', 'https://facebook.com/pages/san-diego-ca/layer3-security-services/207635209271099'],
            ['http://www.facebook.com/pages/agility+inc./114838698562760', 'https://facebook.com/pages/agility+inc./114838698562760'],
            ['http://www.facebook.com/pages/karen-mali-m%c3%bc%c5%9favirlik-logo-muhasebe/194296120603783', 'https://facebook.com/pages/karen-mali-müşavirlik-logo-muhasebe/194296120603783'],
            ['http://www.facebook.com/pages/custom-case-guy/1445342082363874', 'https://facebook.com/pages/custom-case-guy/1445342082363874'],
            ['https://www.facebook.com/sharer/sharer.php?u=asdasd', 'https://facebook.com'],
            ['https://www.facebook.com/sharer.php?u=asdasd', 'https://facebook.com'],
        ];
    }
}
