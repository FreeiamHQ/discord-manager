<?php

namespace App;

class DiscordEmbedField
{
    public function __construct(
        public string $name,
        public string $value,
        public bool $inline = false,
    ) {}
}
