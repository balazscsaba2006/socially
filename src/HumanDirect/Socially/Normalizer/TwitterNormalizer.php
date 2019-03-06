<?php

namespace HumanDirect\Socially\Normalizer;

/**
 * Class TwitterNormalizer.
 */
class TwitterNormalizer extends DefaultNormalizer
{
    /**
     * Replace fb.com domain with facebook.com.
     *
     * {@inheritdoc}
     */
    public function afterNormalization(string $url): string
    {
        $url = parent::afterNormalization($url);

        // strip @ and #! from the URL, eg. twitter.com/@HumanDirectEU becomes twitter.com/HumanDirectEU
        $url = str_replace(['.com/@', '.com/#!/', '.com/share'], '.com/', $url);

        return rtrim($url, '/');
    }
}
