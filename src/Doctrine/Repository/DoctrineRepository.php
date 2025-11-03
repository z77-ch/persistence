<?php
namespace Z77\Core\ORM\Repository;

use Z77\Core\ORM\RepositoryInterface;

final class DoctrineRepository implements RepositoryInterface
{
    private string $entityClass;

    public function __construct(string $entityClass)
    {
        $this->entityClass = $entityClass;
    }

    public function find(int|string $id): ?object
    {
        // Hier würdest du z. B. Doctrine-EntityManager aufrufen
        // Beispiel:
        // return DI::getEntityManager()->find($this->entityClass, $id);
        return null;
    }

    public function findAll(): array { return []; }
    public function findBy(array $criteria): array { return []; }
    public function save(object $entity): void {}
    public function delete(object $entity): void {}
}
