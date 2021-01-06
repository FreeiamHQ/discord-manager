<?php

namespace App\Actions;

use App\Command;
use App\CommandType;
use Discord\Discord;
use App\DiscordAction;
use InvalidArgumentException;

class ExecuteCommandAction
{
    public function execute(Command $command, Discord $discord): void
    {
        throw_unless($command, InvalidArgumentException::class, 'Command is required.');

        $discordAction = new DiscordAction($discord);

        match ($command->name) {
            CommandType::UpdateRole => $discordAction->addRoleToUser($command->user, config("discord.ranks.{$command->value}")),
        };
    }
}
