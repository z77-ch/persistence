<?php

namespace Z77\Persistence\File;

class Bootstrap
{
    public function __contruct()
    {
        return new FileEntityManager(
            new Storage\FileStorage('file_datas')
        );
    }
}
