<?php

namespace App;

use Discord\Discord;
use App\DiscordAction;
use App\ServerCommand;
use App\ServerCommandType;
use InvalidArgumentException;
use App\Actions\SetUserRankAction;

class ServerCommandExecutor
{
    public function __construct(
        private SetUserRankAction $setUserRankAction,
    ) {}

    public function execute(ServerCommand $command, Discord $discord): void
    {
        throw_unless($command, InvalidArgumentException::class, 'Command is required.');

        $discordAction = new DiscordAction($discord);

        match ($command->name) {
            ServerCommandType::UpdateRole => $this->setUserRankAction->execute($discordAction, $command),
            default => '',
        };
    }
}
