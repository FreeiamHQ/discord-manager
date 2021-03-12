<?php

namespace App;

use Discord\Discord;
use App\DiscordAction;
use App\ServerCommand;
use App\ServerCommandType;
use InvalidArgumentException;
use App\Actions\SetUserRankAction;
use App\Actions\AnnounceNewForumThreadAction;
use App\Actions\AnnounceUserAchievedHundredAction;

class ServerCommandExecutor
{
    public function __construct(
        private SetUserRankAction $setUserRankAction,
        private AnnounceNewForumThreadAction $announceForumThreadAction,
        private AnnounceUserAchievedHundredAction $announceUserAchievedHundredAction,
    ) {}

    public function execute(ServerCommand $serverCommand, Discord $discord): void
    {
        throw_unless($serverCommand, InvalidArgumentException::class, 'Command is required.');

        $discordAction = new DiscordAction($discord);

        match ($serverCommand->name) {
            ServerCommandType::UpdateRankRole => $this->setUserRankAction->execute($discordAction, $serverCommand),
            ServerCommandType::AnnounceNewForumThread => $this->announceForumThreadAction->execute($discordAction, $serverCommand),
            ServerCommandType::AchievedHundred => $this->announceUserAchievedHundredAction->execute($discordAction, $serverCommand),
            default => '',
        };
    }
}
