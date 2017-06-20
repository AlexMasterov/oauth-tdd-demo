<?php
declare(strict_types=1);

namespace Oauth\Infrastructure\Storage;

interface StorageInterface
{
    public function set(string $name, $value): void;

    public function get(string $name, $default = null);

    public function has(string $name): bool;

    public function clear(): void;
}
