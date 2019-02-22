<?php

namespace HumanDirect\Socially\Normalizer;

/**
 * Class StackoverflowCareersNormalizer.
 */
class StackoverflowCareersNormalizer extends DefaultNormalizer
{
    /**
     * For Stackoverflow Careers site allow subdomain
     *
     * @inheritdoc
     */
    public function afterNormalization(string $url): string
    {
        return $url;
    }
}
