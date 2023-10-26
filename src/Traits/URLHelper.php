<?php

declare(strict_types=1);

namespace RKocak\Vallet\Traits;

use Illuminate\Support\Str;

trait URLHelper
{
    protected function toFullUrl(string $path): string
    {
        if (Str::startsWith($path, 'http')) {
            return $path;
        }

        return url($path);
    }
}
