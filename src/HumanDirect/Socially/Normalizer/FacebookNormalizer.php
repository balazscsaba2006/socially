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
        $url = str_replace(
            ['fb.com', '.com/sharer.php', '.com/sharer/sharer.php'],
            ['facebook.com', '.com', '.com'],
            $url
        );

        return rtrim($url, '/');
    }
}
