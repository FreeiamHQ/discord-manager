<?php

namespace App\Actions;

use Discord\Discord;
use App\DiscordAction;
use App\ServerCommand;
use App\ServerCommandType;
use InvalidArgumentException;

class ExecuteServerCommandAction
{
    public function execute(ServerCommand $command, Discord $discord): void
    {
        throw_unless($command, InvalidArgumentException::class, 'Command is required.');

        $discordAction = new DiscordAction($discord);

        match ($command->name) {
            ServerCommandType::UpdateRole => $discordAction->addRoleToUser($command->user, config("discord.ranks.{$command->value}"), ucfirst($command->value)),
            default => '',
        };
    }
}
