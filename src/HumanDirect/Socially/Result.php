<?php

namespace HumanDirect\Socially;

use LayerShifter\TLDExtract\ResultInterface as TldResultInterface;

/**
 * Class Result
 */
class Result implements \ArrayAccess, ResultInterface
{
    /**
     * @var TldResultInterface
     */
    private $tldResult;

    /**
     * Constructor of class.
     *
     * @param TldResultInterface $result
     */
    public function __construct(TldResultInterface $result)
    {
        $this->tldResult = $result;
    }

    /**
     * Create instance.
     *
     * @param null|string $subdomain
     * @param null|string $hostname
     * @param null|string $suffix
     *
     * @return ResultInterface
     */
    public static function create(?string $subdomain, ?string $hostname, ?string $suffix): ResultInterface
    {
        return new self(Factory::createTldResult($subdomain, $hostname, $suffix));
    }

    /**
     * Create instance from URL.
     *
     * @param string $url
     *
     * @return ResultInterface
     * @throws SociallyException
     */
    public static function createFromUrl(string $url): ResultInterface
    {
        try {
            $extractor = Factory::createTldExtractor();
        } catch (\Exception $e) {
            throw new SociallyException($e->getMessage(), $e->getCode(), $e);
        }
        $result = $extractor->parse($url);

        return new self(Factory::createTldResult(
            $result->getSubdomain(),
            $result->getHostname(),
            $result->getSuffix()
        ));
    }

    /**
     * Returns subdomain if it exists.
     *
     * @return null|string
     */
    public function getSubdomain(): ?string
    {
        return $this->tldResult->getSubdomain();
    }

    /**
     * Return subdomains if they exist, example subdomain is "www.news", method will return array ['www', 'news'].
     *
     * @return array
     */
    public function getSubdomains(): array
    {
        return $this->tldResult->getSubdomains();
    }

    /**
     * Returns hostname if it exists.
     *
     * @return null|string
     */
    public function getHostname(): ?string
    {
        return $this->tldResult->getHostname();
    }

    /**
     * Returns suffix if it exists.
     *
     * @return null|string
     */
    public function getSuffix(): ?string
    {
        return $this->tldResult->getSuffix();
    }

    /**
     * Method that returns full host record.
     *
     * @return string
     */
    public function getFullHost(): string
    {
        return $this->tldResult->getFullHost();
    }

    /**
     * Returns registrable domain or null.
     *
     * @return null|string
     */
    public function getRegistrableDomain(): ?string
    {
        return $this->tldResult->getRegistrableDomain();
    }

    /**
     * Returns true if domain is valid.
     *
     * @return bool
     */
    public function isValidDomain(): bool
    {
        return $this->tldResult->isValidDomain();
    }

    /**
     * Magic method for run isset on private params.
     *
     * @param string $name Field name
     *
     * @return bool
     */
    public function __isset($name)
    {
        return property_exists($this->tldResult, $name) || property_exists($this, $name);
    }

    /**
     * Converts class fields to string.
     *
     * @return string
     */
    public function __toString(): string
    {
        return (string)$this->tldResult;
    }

    /**
     * Whether or not an offset exists.
     *
     * @param mixed $offset An offset to check for
     *
     * @return bool
     */
    public function offsetExists($offset): bool
    {
        return property_exists($this->tldResult, $offset) || property_exists($this, $offset);
    }

    /**
     * Returns the value at specified offset.
     *
     * @param mixed $offset The offset to retrieve.
     *
     * @throws \OutOfRangeException
     *
     * @return mixed
     */
    public function offsetGet($offset)
    {
        if (property_exists($this->tldResult, $offset)) {
            return $this->tldResult->{$offset};
        }

        if (property_exists($this, $offset)) {
            return $this->{$offset};
        }

        throw new \OutOfRangeException(sprintf('Offset "%s" does not exist.', $offset));
    }

    /**
     * Magic method, controls access to private params.
     *
     * @param string $name Name of params to retrieve
     *
     * @throws \OutOfRangeException
     *
     * @return mixed
     */
    public function __get($name)
    {
        if (property_exists($this->tldResult, $name)) {
            return $this->tldResult->{$name};
        }

        if (property_exists($this, $name)) {
            return $this->{$name};
        }

        throw new \OutOfRangeException(sprintf('Unknown field "%s"', $name));
    }

    /**
     * Magic method, makes params read-only.
     *
     * @param string $name Name of params to retrieve
     * @param mixed $value Value to set
     *
     * @throws \LogicException
     *
     * @return void
     */
    public function __set($name, $value)
    {
        throw new \LogicException("Can't modify an immutable object.");
    }

    /**
     * Disables assigns a value to the specified offset.
     *
     * @param mixed $offset The offset to assign the value to
     * @param mixed $value Value to set
     *
     * @throws \LogicException
     *
     * @return void
     */
    public function offsetSet($offset, $value): void
    {
        throw new \LogicException(
            sprintf("Can't modify an immutable object. You tried to set value '%s' to field '%s'.", $value, $offset)
        );
    }

    /**
     * Disables unset of an offset.
     *
     * @param mixed $offset The offset for unset
     *
     * @throws \LogicException
     *
     * @return void
     */
    public function offsetUnset($offset): void
    {
        throw new \LogicException(sprintf("Can't modify an immutable object. You tried to unset '%s.'", $offset));
    }

    /**
     * Get the domain name components as a native PHP array. The returned array will contain these keys: 'subdomain',
     * 'domain' and 'tld'.
     *
     * @return array
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
     * Get the domain name components as a JSON.
     *
     * @return string
     */
    public function toJson(): string
    {
        return json_encode($this->toArray());
    }
}
