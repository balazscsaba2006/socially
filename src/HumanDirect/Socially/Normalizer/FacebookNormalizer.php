<?php

namespace HumanDirect\Socially\Normalizer;

/**
 * Class FacebookNormalizer.
 */
class FacebookNormalizer extends DefaultNormalizer
{
    /**
     * Replace fb.com domain with facebook.com
     *
     * {@inheritdoc}
     */
    public function afterNormalization(string $url): string
    {
        $url = parent::afterNormalization($url);

        return str_replace('fb.com', 'facebook.com', $url);
    }
}
