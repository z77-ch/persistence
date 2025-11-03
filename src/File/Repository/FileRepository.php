<?php

namespace Z77\Persistence\File\Repository;

use Z77\Persistence\Interface\RepositoryInterface,
    Z77\Persistence\File\Storage\FileStorage,
    Z77\Shared\Libraries\Convention\Naming
;

class FileRepository implements RepositoryInterface
{
    public function __construct(
        private string $class,
        private string $attr,
        private FileStorage $storage
    ) {}

    public function findAll(): array
    {
        $rows = $this->storage->load($this->attr->getPath());

        return array_map(fn($row) => $this->hydrate($row), $rows);
    }

    public function findBy(array $criteria): array
    {
        $all = $this->findAll();

        return array_values(array_filter($all, function ($entity) use ($criteria) {
            foreach ($criteria as $key => $value) {
                $getter = Naming::toGetter($key);
                if ($entity->$getter() !== $value) {
                    return false;
                }
            }
            return true;
        }));
    }

    public function findOneBy(array $criteria): ?object
    {
        $found = $this->findBy($criteria);

        return $found[0] ?? null;
    }

    public function save(object $entity): void
    {
        $data = $this->storage->load($this->path);

        // auto-id handling
        if (!$entity->getId()) {
            $reflection = new  \ReflectionProperty($this->class, 'id');
            $reflection->setAccessible(true);
            $reflection->setValue($entity, $this->nextId($data));
        }

        // overwrite or append
        $found = false;
        foreach ($data as &$row) {
            if ($row['id'] === $entity->getId()) {
                $row = get_object_vars($entity);
                $found = true;
                break;
            }
        }
        if (!$found) {
            $data[] = get_object_vars($entity);
        }

        $this->storage->save($this->path, $data);
    }

    public function delete(object $entity): void
    {
        $data = $this->storage->load($this->path);
        $data = array_filter($data, fn($row) => $row['id'] !== $entity->getId());
        $this->storage->save($this->path, array_values($data));
    }

    private function hydrate(array $row): object
    {
        $class = $this->class;
        $obj = new $class();
        foreach ($row as $k => $v) {
            $setter = Naming::toSetter($key);
            $obj->$setter($v);
        }
        return $obj;
    }

    private function nextId(array $data): int
    {
        $ids = array_column($data, 'id');
        return $ids ? max($ids) + 1 : 1;
    }
}
