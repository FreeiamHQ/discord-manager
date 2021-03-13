<?php

namespace App;

use InvalidArgumentException;

class ServerCommand
{
    public function __construct(
        public ?string $user,
        public string $name,
        public int|string $value,
        public array $meta = [],
    ) {}

    public function getMeta(string $key): mixed
    {
        return $this->meta[$key] ?? null;
    }

    public static function fromArray(array $commandData): static
    {
        throw_if(empty($commandData['name']), InvalidArgumentException::class, 'Command name is required.');

        return new static(
            $commandData['user'] ?? null,
            $commandData['name'],
            $commandData['value'],
            $commandData['meta'] ?? [],
        );
    }
}
