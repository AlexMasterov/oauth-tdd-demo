<?php
declare(strict_types=1);

namespace Oauth\Tests\Infrastructure;

use Oauth\Infrastructure\Storage\StorageInterface;

trait InMemoryStorage
{
    protected function newStorage(array $initialStore = []): StorageInterface
    {
        return new class($initialStore) implements StorageInterface {
            public function __construct(array $initialStore = [])
            {
                $this->store = $initialStore;
            }

            public function set(string $name, $value): void
            {
                $this->store[$name] = $value;
            }

            public function get(string $name, $default = null)
            {
                return $this->store[$name] ?? $default;
            }

            public function has(string $name): bool
            {
                return isset($this->store[$name]);
            }

            public function clear(): void
            {
                $this->store = [];
            }

            /**
             * @var array
             */
            private $store = [];
        };
    }
}
