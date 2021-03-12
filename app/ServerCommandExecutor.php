<?php

namespace App;

use App\Actions\AnnounceNewForumThreadAction;
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
        private AnnounceNewForumThreadAction $announceForumThreadAction,
    ) {}

    public function execute(ServerCommand $serverCommand, Discord $discord): void
    {
        throw_unless($serverCommand, InvalidArgumentException::class, 'Command is required.');

        $discordAction = new DiscordAction($discord);

        match ($serverCommand->name) {
            ServerCommandType::UpdateRole => $this->setUserRankAction->execute($discordAction, $serverCommand),
            ServerCommandType::AnnounceNewForumThread => $this->announceForumThreadAction->execute($discordAction, $serverCommand),
            default => '',
        };
    }
}
