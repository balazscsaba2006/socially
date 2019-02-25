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
     * @var bool
     */
    protected $stripSubdomain = true;

    /**
     * @var bool
     */
    protected $stripQueryStrings = true;

    /**
     * @var array
     */
    protected $allowedQueryParams = [
        'id'
    ];

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
        if (true === $this->stripSubdomain) {
            $url = $this->cleanSubdomain($url);
        }

        if (true === $this->stripQueryStrings) {
            $url = $this->cleanQueryString($url);
        }

        return $url;
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

    /**
     * @param string $url
     *
     * @throws \LayerShifter\TLDExtract\Exceptions\RuntimeException
     *
     * @return string
     */
    private function cleanSubdomain(string $url): string
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
     * @param string $url
     *
     * @return string
     */
    private function cleanQueryString(string $url): string
    {
        // all query params and fragments have to be removed
        if (empty($this->allowedQueryParams)) {
            return strtok($url, '?');
        }

        // first remove fragments from URL
        $url = strtok($url, '#');
        $query = parse_url($url, PHP_URL_QUERY);

        if (null === $query) {
            return $url;
        }

        parse_str($query, $params);
        foreach ($params as $paramKey => $paramValue) {
            if (!\in_array($paramKey, $this->allowedQueryParams, true)) {
                unset($params[$paramKey]);
            }
        }

        return strtok($url, '?') . (\count($params) ? '?' . http_build_query($params) : '');
    }
}
