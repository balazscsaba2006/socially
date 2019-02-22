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
     * @param string|null $platform
     *
     * @return bool
     */
    public function supports(string $platform = null): bool;
}
