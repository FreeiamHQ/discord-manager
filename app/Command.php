<?php

namespace App;

use InvalidArgumentException;

class Command
{
    public function __construct(
        public string $user,
        public string $name,
        public int|string $value,
    ) {}

    public static function fromArray(array $commandData): static
    {
        throw_if(empty($commandData['user']), InvalidArgumentException::class, 'User is required.');
        throw_if(empty($commandData['name']), InvalidArgumentException::class, 'Command name is required.');
        throw_if(empty($commandData['value']), InvalidArgumentException::class, 'Value is required.');

        return new static(
            $commandData['user'],
            $commandData['name'],
            $commandData['value'],
        );
    }
}
