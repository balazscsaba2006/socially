<?php

namespace Tests\HumanDirect\Socially;

use HumanDirect\Socially\NotSupportedException;
use HumanDirect\Socially\Parser;
use HumanDirect\Socially\Result;
use PHPUnit\Framework\TestCase;

/**
 * Class ParserTest.
 */
class ParserTest extends TestCase
{
    private Parser $parser;

    /**
     * Set up test.
     */
    public function setUp(): void
    {
        $this->parser = new Parser();
    }

    /**
     * @dataProvider getValidParseUrls
     */
    public function testValidParse(string $url, Result $expected): void
    {
        $result = $this->parser->parse($url);
        $this->assertEquals($expected, $result);
    }

    /**
     * @return iterable<string, Result>
     */
    public function getValidParseUrls(): iterable
    {
        yield ['http://www.facebook.com/profile.php?id=100000640285573', Result::create('http://www.facebook.com/profile.php?id=100000640285573')];
        yield ['http://github.com/balazscsaba2006', Result::create('http://github.com/balazscsaba2006')];
        yield ['https://ro.linkedin.com/pub/csaba-balazs/20/653/64b', Result::create('https://ro.linkedin.com/pub/csaba-balazs/20/653/64b')];
        yield ['https://plus.google.com/106924247729881790951/about', Result::create('https://plus.google.com/106924247729881790951/about')];
        yield ['http://careers.stackoverflow.com/balazscsaba2006', Result::create('http://careers.stackoverflow.com/balazscsaba2006')];
    }

    /**
     * @dataProvider getInvalidParseUrls
     */
    public function testInvalidParse(string $url): void
    {
        $this->expectException(NotSupportedException::class);
        $this->parser->parse($url);
    }

    /**
     * @return iterable<string, string>
     */
    public function getInvalidParseUrls(): iterable
    {
        yield 'Empty URL' => [''];
        yield 'Localhost IPv4' => ['127.0.0.1'];
        yield 'Localhost IPv6' => ['::1'];

        yield 'Not supported social media URLs' => ['https://subdomain.wordpress.com'];
    }

    /**
     * @dataProvider getIsSocialMediaProfileUrls
     */
    public function testIsSocialMediaProfile(string $url, bool $expected): void
    {
        $result = $this->parser->isSocialMediaProfile($url);
        $this->assertEquals($expected, $result);
    }

    /**
     * @return iterable<string, bool>
     */
    public function getIsSocialMediaProfileUrls(): iterable
    {
        // invalid URLs
        yield ['', false];
        yield ['127.0.0.1', false];
        yield ['::1', false];

        // not supported social media URLs
        yield ['https://subdomain.wordpress.com', false];

        // supported social media URLs
        yield ['https://www.linkedin.com/company/human-direct-romania/', true];
        yield ['http://www.facebook.com/profile.php?id=100000640285573', true];
        yield ['http://github.com/balazscsaba2006', true];
        yield ['http://github.com/BALAZSCSABA2006', true];
        yield ['https://www.linkedin.com/in/csaba-balazs-64b65320/', true];
        yield ['https://ro.linkedin.com/pub/csaba-balazs/20/653/64b', true];
        yield ['https://www.linkedin.com/profile/view?id=144743673', true];
        yield ['https://twitter.com/HumanDirectEU', true];
        yield ['https://angel.co/balazscsaba2006/', true];
        yield ['http://en.gravatar.com/balazscsaba2006', true];
        yield ['http://klout.com/balazs_csaba2006', true];
        yield ['http://klout.com/user/id/447263752102886632', true];
        yield ['http://www.pinterest.com/balazscsaba2006/', true];
        yield ['http://behance.net/balazs-csaba_2006', true];
        yield ['https://bitbucket.org/balazscsaba2006/', true];
        yield ['http://www.dribbble.com/balazscsaba2006', true];
        yield ['http://www.flickr.com/people/28125134@n02', true];
        yield ['https://plus.google.com/106924247729881790951/about', true];
        yield ['https://plus.google.com/u/0/+csaba.balazs', true];
        yield ['https://stackoverflow.com/users/509414/balazscsaba2006', true];
        yield ['http://careers.stackoverflow.com/balazscsaba2006', true];
        yield ['http://www.reddit.com/user/balazscsaba2006', true];
        yield ['http://www.quora.com/profile/balazscsaba-2006', true];
        yield ['http://www.quora.com/balazscsaba-2006', true];
        //yield ['https://facebook.com/sharer.php', false];
        //yield ['https://twitter.com/share', false];
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
     * @return iterable<string, string>
     */
    public function getIdentifyPlatformUrls(): iterable
    {
        yield ['http://www.facebook.com/profile.php?id=100000640285573', 'facebook'];
        yield ['https://www.linkedin.com/in/csaba-balazs-64b65320/', 'linkedin'];
        yield ['https://plus.google.com/106924247729881790951/about', 'google_plus'];
        yield ['https://stackoverflow.com/users/509414/balazscsaba2006', 'stackoverflow'];
        yield ['http://careers.stackoverflow.com/balazscsaba2006', 'stackoverflow.careers'];
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
     * @return iterable<string, string>
     */
    public function getNormalizeUrls(): iterable
    {
        yield ['http://www.FACEBOOK.com/profile.php?id=100000640285573/', 'https://facebook.com/profile.php?id=100000640285573'];
        yield ['https://www.linkedin.com/in/csaba-balazs-64b65320/', 'https://linkedin.com/in/csaba-balazs-64b65320'];
        yield ['https://plus.google.com/106924247729881790951/ABOUT', 'https://plus.google.com/106924247729881790951/about'];
        yield ['https://stackoverflow.com/users/509414/balazscsaba2006', 'https://stackoverflow.com/users/509414/balazscsaba2006'];
        yield ['http://careers.stackoverflow.com/balazscsaba2006/', 'https://careers.stackoverflow.com/balazscsaba2006'];
        yield ['http://some-unsupported-platform.com/', 'http://some-unsupported-platform.com/'];
        yield ['https://ro.linkedin.com/pub/ciprian-cetera%C8%99/53/24b/481', 'https://linkedin.com/pub/ciprian-ceteraș/53/24b/481'];
        yield ['https://ro.linkedin.com/pub/ciprian-ceteraș/53/24b/481', 'https://linkedin.com/pub/ciprian-ceteraș/53/24b/481'];
        yield ['https://ro.linkedin.com/in/ciprian-ceteraș/', 'https://linkedin.com/in/ciprian-ceteraș'];
        yield ['http://www.facebook.com/people/_/100000049946330', 'https://facebook.com/people/_/100000049946330'];
        yield ['http://www.facebook.com/profile.php?id=1294422029', 'https://facebook.com/profile.php?id=1294422029'];
        yield ['http://www.fb.com/profile.php?id=1294422029', 'https://facebook.com/profile.php?id=1294422029'];
        yield ['https://www.linkedin.com/in/csaba-balazs-64b65320/?lipi=urn%3Ali%3Apage%3Ad_flagship3_search_srp_people%3BPx2eriH%2FSVuZyi9fl7ipiA%3D%3D&licu=urn%3Ali%3Acontrol%3Ad_flagship3_search_srp_people-search_srp_result#some-fragment', 'https://linkedin.com/in/csaba-balazs-64b65320/'];
        yield ['https://www.linkedin.com/profile/view?id=202583639', 'https://linkedin.com/profile/view?id=202583639'];

        yield ['http://www.twitter.com/codeschool/dasd?dsadasd', 'https://twitter.com/codeschool/dasd'];
        yield ['https://www.twitter.com/codeschool?dasdad', 'https://twitter.com/codeschool'];
        yield ['https://www.twitter.com/Codeschool?dasdad', 'https://twitter.com/codeschool'];
        yield ['https://twitter.com/codeschool?dasdad', 'https://twitter.com/codeschool'];
        yield ['https://twitter.com/#!/HumanDirectEU?dasdad', 'https://twitter.com/humandirecteu'];
        yield ['https://twitter.com/@HumanDirectEU?dasdad', 'https://twitter.com/humandirecteu'];
        yield ['https://twitter.com/code_school', 'https://twitter.com/code_school'];
        yield ['https://twitter.com/greentextbooks#', 'https://twitter.com/greentextbooks'];
        yield ['https://twitter.com/shopbop#cs=ov=73421773243,os=1,link=footerconnecttwitterlink\',', 'https://twitter.com/shopbop'];
        yield ['https://twitter.com/share', 'https://twitter.com'];

        yield ['https://www.facebook.com/dizzain/?pnref=lhc', 'https://facebook.com/dizzain'];
        yield ['http://www.facebook.com/dizzain?pnref=lhc', 'https://facebook.com/dizzain'];
        yield ['http://facebook.com/dizzain?pnref=lhc', 'https://facebook.com/dizzain'];
        yield ['https://facebook.com/dizzain?pnref=lhc', 'https://facebook.com/dizzain'];
        yield ['https://facebook.com/Dizzain?pnref=lhc', 'https://facebook.com/dizzain'];
        yield ['https://www.facebook.com/pages/fasdfadsfasdfsadf/126287147568059?pnref=lhc', 'https://facebook.com/pages/fasdfadsfasdfsadf/126287147568059'];
        yield ['https://www.facebook.com/PHPtoday-1025912177431644/?fref=ts', 'https://facebook.com/phptoday-1025912177431644'];
        yield ['http://www.facebook.com/pages/The-bloomtrigger-project/125218650866978/path?asdas', 'https://facebook.com/pages/the-bloomtrigger-project/125218650866978/path'];
        yield ['http://www.facebook.com/pages/DealMarket/157833714232772', 'https://facebook.com/pages/dealmarket/157833714232772'];
        // not a valid usage yield ['http://www.facebook.com/#!/pages/dealmarket/157833714232772', 'https://facebook.com/pages/dealmarket/157833714232772'];
        // not a valid usage yield ['http://www.facebook.com/home.php?tests#!/pages/dealmarket/157833714232772', 'https://facebook.com/pages/dealmarket/157833714232772'];
        yield ['http://www.facebook.com/pages/san-diego-ca/layer3-security-services/207635209271099', 'https://facebook.com/pages/san-diego-ca/layer3-security-services/207635209271099'];
        yield ['http://www.facebook.com/pages/agility+inc./114838698562760', 'https://facebook.com/pages/agility+inc./114838698562760'];
        yield ['http://www.facebook.com/pages/karen-mali-m%c3%bc%c5%9favirlik-logo-muhasebe/194296120603783', 'https://facebook.com/pages/karen-mali-müşavirlik-logo-muhasebe/194296120603783'];
        yield ['http://www.facebook.com/pages/custom-case-guy/1445342082363874', 'https://facebook.com/pages/custom-case-guy/1445342082363874'];
        yield ['https://www.facebook.com/sharer/sharer.php?u=asdasd', 'https://facebook.com'];
        yield ['https://www.facebook.com/sharer.php?u=asdasd', 'https://facebook.com'];
    }
}
