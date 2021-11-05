<?php

namespace HumanDirect\Socially;

use JsonException;
use Utopia\Domains\Domain;

/**
 * Class Result.
 */
class Result implements ResultInterface
{
    private Domain $domain;

    public function __construct(Domain $domain)
    {
        $this->domain = $domain;
    }

    /**
     * Create instance from URL.
     *
     * @throws SociallyException
     */
    public static function create(string $url): ResultInterface
    {
        $host = parse_url($url, PHP_URL_HOST);
        $domain = new Domain(!empty($host) ? $host : $url);

        return new self($domain);
    }

    /**
     * Returns subdomain if it exists.
     */
    public function getSubdomain(): ?string
    {
        $host = $this->domain->get();
        if ($host && Util::isValidIp($host)) {
            return null;
        }

        return $this->domain->getSub() ?: null;
    }

    /**
     * Return subdomains if they exist, example subdomain is "www.news", method will return array ['www', 'news'].
     *
     * @return string[]
     */
    public function getSubdomains(): array
    {
        $sub = $this->getSubdomain();

        return $sub ? explode('.', $sub) : [];
    }

    /**
     * Returns hostname if it exists.
     */
    public function getHostname(): ?string
    {
        $host = $this->domain->get();
        if (!$host) {
            return null;
        }

        if (Util::isValidIp($host)) {
            return $host;
        }

        if (null !== $this->getSuffix()) {
            $host = str_ireplace('.'.$this->getSuffix(), '',  $host);
        }

        if (null !== $this->getSubdomain()) {
            $host = str_ireplace($this->getSubdomain().'.', '',  $host);
        }

        return $host;
    }

    /**
     * Returns suffix if it exists.
     */
    public function getSuffix(): ?string
    {
        return $this->domain->getSuffix() ?: null;
    }

    /**
     * Returns true is result is IP.
     */
    public function isIp(): bool
    {
        return null === $this->getSuffix() && Util::isValidIp($this->getHostname());
    }

    /**
     * Method that returns full host record.
     */
    public function getFullHost(): string
    {
        // Case 1: Host has no suffix, possibly IP.
        if (null === $this->getSuffix()) {
            return $this->getHostname();
        }

        // Case 2: Domain with suffix, but without subdomain.
        if (null === $this->getSubdomain()) {
            return $this->getHostname() . '.' . $this->getSuffix();
        }

        // Case 3: Domain with suffix & subdomain.
        return implode('.', [$this->getSubdomain(), $this->getHostname(), $this->getSuffix()]);
    }

    /**
     * Returns registrable domain or null.
     */
    public function getRegistrableDomain(): ?string
    {
        return $this->domain->getRegisterable() ?: null;
    }

    /**
     * Returns true if domain is valid.
     */
    public function isValidDomain(): bool
    {
        return null !== $this->getRegistrableDomain();
    }

    /**
     * Converts class fields to string.
     */
    public function __toString(): string
    {
        return $this->getFullHost();
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return [
            'subdomain' => $this->getSubdomain(),
            'hostname' => $this->getHostname(),
            'suffix' => $this->getSuffix(),
        ];
    }

    /**
     * {@inheritDoc}
     *
     * @throws JsonException
     */
    public function toJson(): string
    {
        return json_encode($this->toArray(), JSON_THROW_ON_ERROR);
    }
}
