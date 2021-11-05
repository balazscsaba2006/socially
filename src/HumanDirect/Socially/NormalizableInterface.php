<?php

namespace HumanDirect\Socially;

/**
 * Class NormalizableInterface.
 */
interface NormalizableInterface
{
    /**
     * Normalize a URL.
     */
    public function normalize(string $url): string;
}
