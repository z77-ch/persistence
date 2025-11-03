<?php

namespace Z77\Persistence\Attributes;

#[\Attribute(\Attribute::TARGET_CLASS)]
class Driver
{
    private string $driverName;
    private string $driver;
    private string $path;

    public function __construct(string $driverName, string $path)
    {
        if (empty($driverName) || empty($path)) {
            throw new \InvalidArgumentException('DriverName and path must be provided.');
        }

        $this->driverName = $driverName;
        $this->path = $path;
    }

    public function getDriverName(): string
    {
        return $this->driverName;
    }

    public function getDriver(): string
    {
        return $this->driver;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setDriver(string $driver): void
    {
        $this->driver = $driver;
    }
}

