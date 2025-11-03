<?php

namespace Z77\Persistence\Resolver;

use Z77\Core\DI,
    Z77\Persistence\Interface\RepositoryInterface,
    Z77\Persistence\Resolver\DataSourceResolver
;

final class UnifiedEntityManager
{
    private array $managerCache = [];

    public function __construct(
        private DataSourceResolver $resolver)
    {}

    public function getRepository(string $className): RepositoryInterface
    {
        $entityAttr = $this->resolver->getDriverName($className);
        $driver = $entityAttr->driver;

        if (!isset($this->managerCache[$driver])) {
            $this->managerCache[$driver] = $this->bootManager($driver);
        }

        return $this->managerCache[$driver]->getRepository($className, $entityAttr);
    }

    private function bootManager(string $driver)
    {
        $bootstrapClass = Naming::toNamespaceString(
            ['Z77', 'Persistence', $driver]
        ).'Bootstrap';
        $bootstrap = new $bootstrapClass();

        return $bootstrap->getEntityManager();
    }
}
