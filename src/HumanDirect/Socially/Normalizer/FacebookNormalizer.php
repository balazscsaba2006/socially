<?php

namespace HumanDirect\Socially\Normalizer;

/**
 * Class FacebookNormalizer.
 */
class FacebookNormalizer extends DefaultNormalizer
{
    /**
     * Replace fb.com domain with facebook.com.
     *
     * {@inheritdoc}
     */
    public function afterNormalization(string $url): string
    {
        $url = parent::afterNormalization($url);
        $url = str_replace('fb.com', 'facebook.com', $url);

        $url = str_replace(['.com/sharer.php', '.com/sharer/sharer.php'], '.com', $url);

        return rtrim($url, '/');
    }
}
