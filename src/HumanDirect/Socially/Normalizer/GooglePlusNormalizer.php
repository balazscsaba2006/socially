<?php

namespace HumanDirect\Socially\Normalizer;

/**
 * Class GooglePlusNormalizer.
 */
class GooglePlusNormalizer extends DefaultNormalizer
{
    /**
     * For Google Plus site allow subdomain
     *
     * @inheritdoc
     */
    public function afterNormalization(string $url): string
    {
        return $url;
    }
}
