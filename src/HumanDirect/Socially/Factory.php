<?php

namespace HumanDirect\Socially;

use LayerShifter\TLDExtract\Extract;
use LayerShifter\TLDExtract\Result as TldResult;
use LayerShifter\TLDExtract\ResultInterface as TldResultInterface;

/**
 * Class Factory.
 */
class Factory
{
    /**
     * @return Parser
     */
    public static function createParser(): Parser
    {
        return new Parser();
    }

    /**
     * @return Extract
     *
     * @throws \LayerShifter\TLDExtract\Exceptions\RuntimeException
     */
    public static function createTldExtractor(): Extract
    {
        return new Extract();
    }

    /**
     * @param null|string $subdomain
     * @param null|string $hostname
     * @param null|string $suffix
     *
     * @return TldResultInterface
     */
    public static function createTldResult(?string $subdomain, ?string $hostname, ?string $suffix): TldResultInterface
    {
        return new TldResult($subdomain, $hostname, $suffix);
    }
}
