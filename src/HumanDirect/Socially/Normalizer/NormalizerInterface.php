<?php

namespace HumanDirect\Socially\Normalizer;

use HumanDirect\Socially\NormalizableInterface;

/**
 * Interface NormalizerInterface.
 */
interface NormalizerInterface extends NormalizableInterface, SupportsNormalizerInterface
{
    /**
     * @param string $url
     *
     * @return string
     */
    public function afterNormalization(string $url): string;
}
