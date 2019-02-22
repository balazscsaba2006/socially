<?php

namespace HumanDirect\Socially;

/**
 * Class NormalizableInterface.
 */
interface NormalizableInterface
{
    /**
     * Normalize a URL.
     *
     * @param string $url
     *
     * @return string
     */
    public function normalize(string $url): string;
}
