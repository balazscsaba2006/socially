<?php

namespace Tests\HumanDirect\Socially;

use HumanDirect\Socially\Result;
use PHPUnit\Framework\TestCase;

/**
 * Class ResultTest
 */
class ResultTest extends TestCase
{
    /**
     * Object for tests.
     */
    private Result $entity;

    /**
     * Method that setups test's environment.
     */
    public function setUp(): void
    {
        $this->entity = Result::create('192.168.0.1');
    }

    /**
     * Test for __constructor.
     */
    public function testConstruct(): void
    {
        static::assertNull($this->entity->getSubdomain());
        static::assertEquals('192.168.0.1', $this->entity->getHostname());
        static::assertNull($this->entity->getSuffix());

        $entity = Result::create('domain.com');

        static::assertNull($this->entity->getSubdomain());
        static::assertEquals('domain', $entity->getHostname());
        static::assertEquals('com', $entity->getSuffix());

        $entity = Result::create('www.news.domain.com');

        static::assertEquals('www.news', $entity->getSubdomain());
        static::assertEquals(['www', 'news'], $entity->getSubdomains());
        static::assertEquals('domain', $entity->getHostname());
        static::assertEquals('com', $entity->getSuffix());
        static::assertEquals('www.news.domain.com', $entity->getFullHost());
        static::assertEquals('domain.com', $entity->getRegistrableDomain());

        static::assertArrayHasKey('subdomain', $entity->toArray());
        static::assertArrayHasKey('hostname', $entity->toArray());
        static::assertArrayHasKey('suffix', $entity->toArray());
    }

    /**
     * Test for static createFromUrl.
     */
    public function testStaticCreateFromUrl(): void
    {
        $entity = Result::create('https://www.linkedin.com/in/csaba-balazs-64b65320/');

        static::assertEquals('www', $entity->getSubdomain());
        static::assertEquals('linkedin', $entity->getHostname());
        static::assertEquals('com', $entity->getSuffix());

        static::assertArrayHasKey('subdomain', $entity->toArray());
        static::assertArrayHasKey('hostname', $entity->toArray());
        static::assertArrayHasKey('suffix', $entity->toArray());
    }

    /**
     * Test domain entry.
     */
    public function testDomain(): void
    {
        $result = Result::create('github.com');

        static::assertEquals('github.com', $result->getFullHost());
        static::assertEquals(null, $result->getSubdomain());
        static::assertEquals([], $result->getSubdomains());
        static::assertEquals('github.com', $result->getRegistrableDomain());
        static::assertTrue($result->isValidDomain());
        static::assertFalse($result->isIp());
    }

    /**
     * Test subdomain entry.
     */
    public function testSubDomain(): void
    {
        $result = Result::create('shop.github.com');

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
     * Test for toJson().
     *
     * @throws \JsonException
     */
    public function testToJson(): void
    {
        static::assertJsonStringEqualsJsonString(
            json_encode((object)[
                'subdomain' => null,
                'hostname' => '192.168.0.1',
                'suffix' => null,
            ], JSON_THROW_ON_ERROR),
            $this->entity->toJson()
        );
    }

    /**
     * Test for magic method __toString().
     */
    public function testToString(): void
    {
        static::assertEquals('192.168.0.1', (string) $this->entity);
    }
}
