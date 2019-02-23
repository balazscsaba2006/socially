<?php

namespace HumanDirect\Socially\Normalizer;

/**
 * Interface SupportsNormalizerInterface.
 */
interface SupportsNormalizerInterface
{
    /**
     * Does normalizer support platform?
     *
     * @param string $platform
     *
     * @return bool
     */
    public function supports(string $platform): bool;
}
