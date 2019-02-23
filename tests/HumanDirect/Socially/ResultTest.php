<?php

namespace Tests\HumanDirect\Socially;

use HumanDirect\Socially\Factory;
use HumanDirect\Socially\Result;
use LayerShifter\TLDExtract\Extract;
use LayerShifter\TLDExtract\Result as TldResult;
use PHPUnit\Framework\TestCase;

/**
 * Class ResultTest
 */
class ResultTest extends TestCase
{
    /**
     * @var Extract
     */
    private $extract;

    /**
     * Object for tests.
     *
     * @var Result
     */
    private $entity;

    /**
     * Method that setups test's environment.
     *
     * @return void
     * @throws \LayerShifter\TLDExtract\Exceptions\RuntimeException
     */
    public function setUp()
    {
        $this->extract = Factory::createTldExtractor();
        $this->entity = new Result(new TldResult(null, '192.168.0.1', null));
    }

    /**
     * Test for __constructor.
     *
     * @return void
     */
    public function testConstruct()
    {
        static::assertNull($this->entity->subdomain);
        static::assertEquals('192.168.0.1', $this->entity->hostname);
        static::assertNull($this->entity->suffix);

        $entity = new Result(new TldResult(null, 'domain', 'com'));

        static::assertNull($this->entity->subdomain);
        static::assertEquals('domain', $entity->hostname);
        static::assertEquals('com', $entity->suffix);

        unset($entity);

        $entity = new Result(new TldResult('www.news', 'domain', 'com'));

        static::assertEquals('www.news', $entity->subdomain);
        static::assertEquals(['www', 'news'], $entity->getSubdomains());
        static::assertEquals('domain', $entity->hostname);
        static::assertEquals('com', $entity->suffix);
        static::assertEquals('www.news.domain.com', $entity->getFullHost());
        static::assertEquals('domain.com', $entity->getRegistrableDomain());

        static::assertArrayHasKey('subdomain', $entity);
        static::assertArrayHasKey('hostname', $entity);
        static::assertArrayHasKey('suffix', $entity);
    }

    /**
     * Test for static create.
     *
     * @return void
     */
    public function testStaticCreate()
    {
        $entity = Result::create('www', 'domain', 'com');

        static::assertEquals('www', $entity->subdomain);
        static::assertEquals('domain', $entity->hostname);
        static::assertEquals('com', $entity->suffix);

        static::assertArrayHasKey('subdomain', $entity);
        static::assertArrayHasKey('hostname', $entity);
        static::assertArrayHasKey('suffix', $entity);
    }

    /**
     * Test for static createFromUrl.
     *
     * @return void
     */
    public function testStaticCreateFromUrl()
    {
        $entity = Result::createFromUrl('https://www.linkedin.com/in/csaba-balazs-64b65320/');

        static::assertEquals('www', $entity->subdomain);
        static::assertEquals('linkedin', $entity->hostname);
        static::assertEquals('com', $entity->suffix);

        static::assertArrayHasKey('subdomain', $entity);
        static::assertArrayHasKey('hostname', $entity);
        static::assertArrayHasKey('suffix', $entity);
    }

    /**
     * Test domain entry.
     *
     * @return void
     */
    public function testDomain()
    {
        $result = $this->extract->parse('github.com');

        static::assertEquals('github.com', $result->getFullHost());
        static::assertEquals(null, $result->getSubdomain());
        static::assertEquals([], $result->getSubdomains());
        static::assertEquals('github.com', $result->getRegistrableDomain());
        static::assertTrue($result->isValidDomain());
        static::assertFalse($result->isIp());
    }

    /**
     * Test subdomain entry.
     *
     * @return void
     */
    public function testSubDomain()
    {
        $result = $this->extract->parse('shop.github.com');

        static::assertEquals('shop.github.com', $result->getFullHost());
        static::assertEquals('shop', $result->getSubdomain());
        static::assertCount(1, $result->getSubdomains());
        static::assertContainsOnly('string', $result->getSubdomains());
        static::assertEquals(['shop'], $result->getSubdomains());
        static::assertEquals('github.com', $result->getRegistrableDomain());
        static::assertTrue($result->isValidDomain());
        static::assertFalse($result->isIp());
    }

    /**
     * Test subdomain entries.
     *
     * @return void
     */
    public function testSubdomains()
    {
        $result = $this->extract->parse('new.shop.github.com');

        static::assertEquals('new.shop.github.com', $result->getFullHost());
        static::assertEquals('new.shop', $result->getSubdomain());
        static::assertCount(2, $result->getSubdomains());
        static::assertContainsOnly('string', $result->getSubdomains());
        static::assertEquals(['new', 'shop'], $result->getSubdomains());
        static::assertEquals('github.com', $result->getRegistrableDomain());
        static::assertTrue($result->isValidDomain());
        static::assertFalse($result->isIp());
    }

    /**
     * Test for toJson().
     *
     * @return void
     */
    public function testToJson()
    {
        static::assertJsonStringEqualsJsonString(
            json_encode((object)[
                'subdomain' => null,
                'hostname'  => '192.168.0.1',
                'suffix'    => null,
            ]),
            $this->entity->toJson()
        );
    }

    /**
     * Test for magic method __toString().
     *
     * @return void
     */
    public function testToString()
    {
        static::assertEquals('192.168.0.1', (string) $this->entity);
    }

    /**
     * Test for magic method __isset().
     *
     * @return void
     */
    public function testIsset()
    {
        static::assertNull($this->entity->subdomain);
        static::assertNotNull($this->entity->hostname);
        static::assertNull($this->entity->suffix);

        /* @noinspection PhpUndefinedFieldInspection
         * Test for not existing field
         */
        static::assertEquals(false, isset($this->entity->test));
    }

    /**
     * Test for magic method __set().
     *
     * @expectedException \LogicException
     *
     * @return void
     */
    public function testSet()
    {
        $this->entity->offsetSet('hostname', 'another-domain');
    }

    /**
     * Test for magic method __set().
     *
     * @expectedException \LogicException
     *
     * @return void
     */
    public function testSetViaProperty()
    {
        $this->entity->hostname = 'another-domain';
    }

    /**
     * Test for magic method __get().
     *
     * @expectedException \OutOfRangeException
     *
     * @return void
     */
    public function testGet()
    {
        /* @noinspection PhpUndefinedFieldInspection
         * Test for not existing field
         */
        $this->entity->hostname1;
    }

    /**
     * Test for magic method __offsetSet().
     *
     * @expectedException \LogicException
     *
     * @return void
     */
    public function testOffsetSet()
    {
        $this->entity['hostname'] = 'another-domain';
    }

    /**
     * Test for magic method __offsetGet().
     *
     * @return void
     */
    public function testOffsetGet()
    {
        static::assertEquals('192.168.0.1', $this->entity['hostname']);
    }

    /**
     * Test for magic method __offsetUnset().
     *
     * @expectedException \LogicException
     *
     * @return void
     */
    public function testOffsetUnset()
    {
        unset($this->entity['hostname']);
    }
}
