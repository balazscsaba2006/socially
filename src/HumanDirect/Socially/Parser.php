<?php

namespace HumanDirect\Socially;

/**
 * Class Parser.
 */
class Parser implements ParserInterface
{
    /**
     * Returns true if the supplied URL is a valid social media profile URL
     *
     * @param string $url
     *
     * @return bool
     */
    public function isSocialMediaProfile(string $url): bool
    {
        if (!$this->isValidUrl($url)) {
            return false;
        }

        foreach (self::SOCIAL_MEDIA_PATTERNS as $platform => $regex) {
            foreach ($regex as $pattern) {
                if (preg_match('#'.$pattern.'#i', $url)) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Validates if supplied URL is valid and not an IP address
     *
     * @param string $url
     *
     * @return bool
     */
    private function isValidUrl(string $url): bool
    {
        $cleaned = $this->cleanUrl($url);
        if (!filter_var($cleaned, FILTER_VALIDATE_URL)) {
            return $url;
        }

        $tldExtractor = Factory::createTldExtractor();
        $result = $tldExtractor->parse($cleaned);

        return $result->isValidDomain();
    }

    /**
     * @param string $url
     *
     * @return string
     */
    private function cleanUrl(string $url): string
    {
        return strtolower(trim($url));
    }
}
