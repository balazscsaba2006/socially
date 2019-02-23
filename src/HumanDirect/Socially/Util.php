<?php

namespace HumanDirect\Socially;

/**
 * Class Util.
 */
class Util
{
    /**
     * @param string $input
     *
     * @return string
     */
    public static function toCamelCase(string $input): string
    {
        return str_replace(' ', '', ucwords(str_replace(['.', '_', '-'], ' ', $input)));
    }

    /**
     * Validates if supplied URL is valid and not an IP address.
     *
     * @param string $url
     *
     * @return bool
     */
    public static function isValidUrl(string $url): bool
    {
        $cleaned = self::cleanUrl($url);
        if (!filter_var($cleaned, FILTER_VALIDATE_URL)) {
            return false;
        }

        $result = Result::createFromUrl($cleaned);

        return $result->isValidDomain();
    }

    /**
     * @param string $url
     *
     * @return string
     */
    public static function cleanUrl(string $url): string
    {
        return mb_strtolower(trim($url));
    }
}
