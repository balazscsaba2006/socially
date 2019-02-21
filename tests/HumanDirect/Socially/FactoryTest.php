<?php

namespace Tests\HumanDirect\Socially;

use HumanDirect\Socially\Factory;
use HumanDirect\Socially\Parser;
use LayerShifter\TLDExtract\Extract;
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
}
