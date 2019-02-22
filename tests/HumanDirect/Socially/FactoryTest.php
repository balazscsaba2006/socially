<?php

namespace Tests\HumanDirect\Socially;

use HumanDirect\Socially\Factory;
use HumanDirect\Socially\Parser;
use LayerShifter\TLDExtract\Extract;
use LayerShifter\TLDExtract\Result;
use LayerShifter\TLDExtract\ResultInterface;
use PHPUnit\Framework\TestCase;

class FactoryTest extends TestCase
{
    public function testCreateParser(): void
    {
        $parser = Factory::createParser();

        $this->assertInstanceOf(Parser::class, $parser);
    }

    public function testCreateTldExtractor(): void
    {
        $tldExtractor = Factory::createTldExtractor();

        $this->assertInstanceOf(Extract::class, $tldExtractor);
    }

    public function testCreateTldResult(): void
    {
        $tldResult = Factory::createTldResult('www', 'domain', 'com');

        $this->assertInstanceOf(Result::class, $tldResult);
        $this->assertInstanceOf(ResultInterface::class, $tldResult);
    }
}
