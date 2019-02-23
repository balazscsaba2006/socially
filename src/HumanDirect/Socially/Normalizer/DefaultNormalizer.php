<?php

namespace HumanDirect\Socially\Normalizer;

use HumanDirect\Socially\Factory;
use HumanDirect\Socially\Util;

/**
 * Class DefaultNormalizer.
 */
class DefaultNormalizer implements NormalizerInterface
{
    /**
     * Normalize a URL.
     *
     * @param string $url
     *
     * @return string
     */
    public function normalize(string $url): string
    {
        $url = rawurldecode($url);
        $url = $this->cleanUrl($url);
        $url = str_replace('http://', 'https://', $url);

        return $this->afterNormalization($url);
    }

    /**
     * {@inheritdoc}
     */
    public function afterNormalization(string $url): string
    {
        $tldExtractor = Factory::createTldExtractor();
        $result = $tldExtractor->parse($url);
        $subdomain = $result->getSubdomain();

        if (null === $subdomain) {
            return $url;
        }

        return str_replace($subdomain . '.', '', $url);
    }

    /**
     * {@inheritdoc}
     */
    public function supports(string $platform): bool
    {
        return $this->getName() === Util::toCamelCase($platform);
    }

    /**
     * @throws \ReflectionException
     *
     * @return string
     */
    protected function getName(): string
    {
        $shortName = (new \ReflectionClass($this))->getShortName();

        return substr($shortName, 0, -10);
    }

    /**
     * @param string $url
     *
     * @return string
     */
    protected function cleanUrl(string $url): string
    {
        return rtrim(Util::cleanUrl($url), '/');
    }
}
