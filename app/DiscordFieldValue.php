<?php

namespace App;

class DiscordFieldValue
{
    public function __construct(
        public string $name,
        public string $value,
        public bool $inline = false,
    ) {}
}
