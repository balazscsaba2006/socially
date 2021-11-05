<?php

namespace HumanDirect\Socially;

use FilesystemIterator;
use HumanDirect\Socially\Normalizer\DefaultNormalizer;
use HumanDirect\Socially\Normalizer\NormalizerInterface;

/**
 * Class Parser.
 */
class Parser implements ParserInterface
{
    /**
     * @var NormalizerInterface[]
     */
    private array $normalizers;

    /**
     * {@inheritdoc}
     */
    public function parse(string $url): ResultInterface
    {
        if (!$this->isSocialMediaProfile($url)) {
            throw new NotSupportedException('Supplied URL is not a social media profile URL.');
        }

        return Result::create($url);
    }

    /**
     * {@inheritdoc}
     */
    public function normalize(string $url): string
    {
        if (!isset($this->normalizers)) {
            $this->loadNormalizers();
        }

        try {
            $platform = $this->identifyPlatform($url);
        } catch (NotSupportedException | \Exception $e) {
            return $url;
        }

        $normalizer = $this->getNormalizer($platform);

        return $normalizer->normalize($url);
    }

    /**
     * {@inheritdoc}
     */
    public function isSocialMediaProfile(string $url): bool
    {
        if (!Util::isValidUrl($url)) {
            return false;
        }

        try {
            $this->identifyPlatform($url);
        } catch (NotSupportedException | \Exception $e) {
            return false;
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function identifyPlatform(string $url): string
    {
        foreach (self::SOCIAL_MEDIA_PATTERNS as $platform => $regex) {
            foreach ($regex as $prefix => $pattern) {
                if (preg_match('#' . $pattern . '#i', rawurldecode($url))) {
                    return \is_string($prefix) ? sprintf('%s.%s', $platform, $prefix) : $platform;
                }
            }
        }

        throw new NotSupportedException('Could not identify platform for URL.');
    }

    /**
     * Load normalizers.
     */
    private function loadNormalizers(): void
    {
        $normalizerNS = '\\HumanDirect\\Socially\\Normalizer\\';
        $directory = new \RecursiveDirectoryIterator(
            __DIR__ . '/Normalizer',
            FilesystemIterator::SKIP_DOTS
        );
        $files = new \RecursiveCallbackFilterIterator($directory, function ($current, $key, $iterator) use ($normalizerNS) {
            $className = str_replace('.php', '', $current->getFilename());
            $isNormalizer = 'Normalizer' === substr($className, -10);

            if (!$isNormalizer || $current->isDir() || $iterator->hasChildren()) {
                return false;
            }

            $r = new \ReflectionClass($normalizerNS . $className);

            return $r->isInstantiable();
        });

        foreach ($files as $file) {
            $className = $normalizerNS . str_replace('.php', '', $file->getFilename());
            $this->normalizers[] = new $className();
        }
    }

    /**
     * Get a normalizer for a specific platform or a default normalizer.
     */
    private function getNormalizer(string $platform): NormalizerInterface
    {
        foreach ($this->normalizers as $normalizer) {
            if ($normalizer->supports($platform)) {
                return $normalizer;
            }
        }

        return new DefaultNormalizer();
    }
}
