<?php

namespace HumanDirect\Socially;

/**
 * Class Util.
 */
class Util
{
    public static function toCamelCase(string $input): string
    {
        return str_replace(' ', '', ucwords(str_replace(['.', '_', '-'], ' ', $input)));
    }

    /**
     * Validates if supplied URL is valid and not an IP address.
     */
    public static function isValidUrl(string $url): bool
    {
        $cleaned = self::cleanUrl($url);
        if (!filter_var($cleaned, FILTER_VALIDATE_URL)) {
            return false;
        }

        $result = Result::create($cleaned);

        return $result->isValidDomain();
    }

    public static function isValidIp(string $hostname): bool
    {
        $hostname = trim($hostname);

        // Strip the wrapping square brackets from IPv6 addresses.
        if (self::startsWith($hostname, '[') && self::endsWith($hostname, ']')) {
            $hostname = substr($hostname, 1, -1);
        }

        return (bool) filter_var($hostname, FILTER_VALIDATE_IP);
    }

    public static function cleanUrl(string $url): string
    {
        return mb_strtolower(trim($url));
    }

    /**
     * Determine if a given string starts with a given substring.
     *
     * @param string|array $needles
     */
    public static function startsWith(string $haystack, $needles): bool
    {
        foreach ((array) $needles as $needle) {
            if ($needle !== '' && mb_strpos($haystack, $needle) === 0) {
                return true;
            }
        }

        return false;
    }

    /**
     * Determine if a given string ends with a given substring.
     *
     * @param string|array $needles
     */
    public static function endsWith(string $haystack, $needles): bool
    {
        foreach ((array) $needles as $needle) {
            if ((string) $needle === self::substr($haystack, -self::length($needle))) {
                return true;
            }
        }

        return false;
    }

    /**
     * Returns the portion of string specified by the start and length parameters.
     */
    public static function substr(string $string, int $start, int $length = null): string
    {
        return mb_substr($string, $start, $length, 'UTF-8');
    }

    /**
     * Return the length of the given string.
     */
    public static function length(string $value): int
    {
        return mb_strlen($value, 'UTF-8');
    }
}
