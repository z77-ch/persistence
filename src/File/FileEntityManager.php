<?php

namespace Z77\Persistence\File;

use Z77\Shared\Attributes\Entity as EntityAttr,
    Z77\Persistence\File\Repository\FileRepository,
    Z77\Persistence\File\Storage\FileStorage
;

class FileEntityManager
{
    private array $repositories = [];
    private FileStorage $storage;

    public function __construct(FileStorage $storage)
    {
        $this->storage = $storage;
    }

    public function getRepository(
        string $entityClass,
        EntityAttr $entityAttr
    ): FileRepository {
        if (isset($this->repositories[$entityClass])) {
            return $this->repositories[$entityClass];
        }

        $repo = new FileRepository($entityClass, $entityAttr, $this->storage);
        $this->repositories[$entityClass] = $repo;

        return $repo;
    }
}
