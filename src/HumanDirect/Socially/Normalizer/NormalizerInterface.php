<?php

namespace HumanDirect\Socially\Normalizer;

use HumanDirect\Socially\NormalizableInterface;

/**
 * Interface NormalizerInterface.
 */
interface NormalizerInterface extends NormalizableInterface, SupportsNormalizerInterface
{
    public function afterNormalization(string $url): string;
}
