<?php

namespace {
    use HumanDirect\Socially\Parser;

    function socially_isSocialMediaProfile(string $url): bool
    {
        static $parser = null;

        if (null === $parser) {
            $parser = new Parser();
        }

        return $parser->isSocialMediaProfile($url);
    }

    function socially_normalize(string $url): string
    {
        static $parser = null;

        if (null === $parser) {
            $parser = new Parser();
        }

        return $parser->normalize($url);
    }
}
