<?php

namespace HumanDirect\Socially\Normalizer;

use HumanDirect\Socially\Util;
use Utopia\Domains\Domain;

/**
 * Class DefaultNormalizer.
 */
class DefaultNormalizer implements NormalizerInterface
{
    protected bool $stripSubdomain = true;
    protected bool $stripQueryStrings = true;
    protected array $allowedQueryParams = ['id'];

    /**
     * Normalize a URL.
     */
    public function normalize(string $url): string
    {
        $url = rawurldecode($url);
        $url = $this->cleanUrl($url);
        $url = str_replace('http://', 'https://', $url);

        return $this->afterNormalization($url);
    }

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

    protected function getName(): string
    {
        $shortName = (new \ReflectionClass($this))->getShortName();

        return substr($shortName, 0, -10);
    }

    protected function cleanUrl(string $url): string
    {
        return rtrim(Util::cleanUrl($url), '/');
    }

    private function cleanSubdomain(string $url): string
    {
        $domain = new Domain(parse_url($url, PHP_URL_HOST));
        $subdomain = $domain->getSub();

        return !empty($subdomain) ? str_replace($subdomain . '.', '', $url) : $url;
    }

    private function cleanQueryString(string $url): string
    {
        // all query params and fragments have to be removed
        if (empty($this->allowedQueryParams)) {
            return strtok($url, '?');
        }

        // replace shebang/hashbang with temporary placeholder
        $url = str_replace('#!', '`hashbang`', $url);

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

        // revert shebang/hashbang placeholder
        $url = str_replace('`hashbang`', '#!', $url);

        return strtok($url, '?') . (\count($params) ? '?' . http_build_query($params) : '');
    }
}
