<?php

namespace {
    use HumanDirect\Socially\Factory;

    /**
     * @param string $url
     *
     * @return bool
     */
    function socially_isSocialMediaProfile(string $url): bool
    {
        static $parser = null;

        if (null === $parser) {
            $parser = Factory::createParser();
        }

        return $parser->isSocialMediaProfile($url);
    }

    /**
     * @param string $url
     *
     * @return string
     */
    function socially_normalize(string $url): string
    {
        static $parser = null;

        if (null === $parser) {
            $parser = Factory::createParser();
        }

        return $parser->normalize($url);
    }
}
