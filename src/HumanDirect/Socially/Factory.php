<?php

namespace HumanDirect\Socially;

use LayerShifter\TLDExtract\Extract;

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
}
