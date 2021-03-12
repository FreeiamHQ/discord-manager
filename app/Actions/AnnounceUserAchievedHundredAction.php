<?php

namespace App\Actions;

use App\DiscordAction;
use App\ServerCommand;

class AnnounceUserAchievedHundredAction
{
    public function execute(DiscordAction $discordAction, ServerCommand $serverCommand): void
    {
        $discordAction->botTalk('Congrats on achieving 💯 today! 🎉', $serverCommand->user);
    }
}
