<?php

declare(strict_types=1);

namespace RKocak\Vallet\Traits;

trait HashesString
{
    public function generateHash(string $str): string
    {
        return base64_encode(pack('H*', sha1($str)));
    }
}
