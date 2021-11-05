<?php

namespace HumanDirect\Socially;

/**
 * Interface for parsing results.
 */
interface ResultInterface
{
    /**
     * Create instance.
     */
    public static function create(string $url): self;

    /**
     * Returns subdomain if it exists.
     */
    public function getSubdomain(): ?string;

    /**
     * Returns hostname if it exists.
     */
    public function getHostname(): ?string;

    /**
     * Returns suffix if it exists.
     */
    public function getSuffix(): ?string;

    /**
     * Returns true is result is IP.
     */
    public function isIp(): bool;

    /**
     * Method that returns full host record.
     */
    public function getFullHost(): string;

    /**
     * Returns registrable domain or null.
     */
    public function getRegistrableDomain(): ?string;

    /**
     * Returns true if domain is valid.
     */
    public function isValidDomain(): bool;

    /**
     * Get the domain name components as a native PHP array. The returned array will contain these keys: 'subdomain',
     * 'domain' and 'tld'.
     *
     * @return array{subdomain:null|string, hostname:null|string, suffix:null|string}
     */
    public function toArray(): array;

    /**
     * Get the domain name components as a JSON.
     */
    public function toJson(): string;
}
