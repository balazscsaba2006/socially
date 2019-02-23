<?php

namespace HumanDirect\Socially;

use LayerShifter\TLDExtract\ResultInterface as TldResultInterface;

/**
 * Interface for parsing results.
 */
interface ResultInterface extends \ArrayAccess
{
    /**
     * Constructor of class.
     *
     * @param TldResultInterface $result
     */
    public function __construct(TldResultInterface $result);

    /**
     * Create instance.
     *
     * @param null|string $subdomain
     * @param null|string $hostname
     * @param null|string $suffix
     *
     * @return ResultInterface
     */
    public static function create(?string $subdomain, ?string $hostname, ?string $suffix): self;

    /**
     * Returns subdomain if it exists.
     *
     * @return null|string
     */
    public function getSubdomain(): ?string;

    /**
     * Return subdomains if they exist, example subdomain is "www.news", method will return array ['www', 'news'].
     *
     * @return array
     */
    public function getSubdomains(): array;

    /**
     * Returns hostname if it exists.
     *
     * @return null|string
     */
    public function getHostname(): ?string;

    /**
     * Returns suffix if it exists.
     *
     * @return null|string
     */
    public function getSuffix(): ?string;

    /**
     * Method that returns full host record.
     *
     * @return string
     */
    public function getFullHost(): string;

    /**
     * Returns registrable domain or null.
     *
     * @return null|string
     */
    public function getRegistrableDomain(): ?string;

    /**
     * Returns true if domain is valid.
     *
     * @return bool
     */
    public function isValidDomain(): bool;
}
