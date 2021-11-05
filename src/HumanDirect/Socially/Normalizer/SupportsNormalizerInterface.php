<?php

namespace HumanDirect\Socially\Normalizer;

/**
 * Interface SupportsNormalizerInterface.
 */
interface SupportsNormalizerInterface
{
    /**
     * Does normalizer support platform?
     */
    public function supports(string $platform): bool;
}
