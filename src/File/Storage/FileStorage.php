<?php

namespace Z77\Core\ORM\Storage;

class FileStorage
{
    private string $basePath;

    public function __contruct(string $basePath = 'data')
    {
        $this->basePath = ABS_BASE_PATH.'/'.$basePath.'/';

        if (!is_dir($this->basePath)) {
            mkdir($this->basePath, 0755, true);
        }
    }

    public function load(string $path): array
    {
        $path = trim($path, '/');
        if (!file_exists($this->basePath.$path)) return [];
        $json = file_get_contents($this->basePath.$path);
        $data = json_decode($json, true) ?? [];

        return is_array($data) ? $data : [];
    }

    public function save(string $path, array $data): void
    {
        $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        file_put_contents($this->basePath.$path, $json, LOCK_EX);
    }
}
