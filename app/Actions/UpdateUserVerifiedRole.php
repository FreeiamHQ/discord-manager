<?php

namespace App\Actions;

use App\DiscordAction;
use App\ServerCommand;

class UpdateUserVerifiedRole
{
    public function execute(DiscordAction $discordAction, ServerCommand $serverCommand): void
    {
        $verifiedUserRoleId = config('discord.roles.verified-user');

        $onDoneDisconnect = fn () => $discordAction->botTalk('has disconnected their FREEIAM account from Discord and lost their verification status ❌', $serverCommand->user);
        $onDoneConnect = fn () => $discordAction->botTalk('has connected their FREEIAM account with Discord ✅', $serverCommand->user);

        match ($serverCommand->value) {
            0 => $discordAction->removeUserRole($serverCommand->user, $verifiedUserRoleId, $onDoneDisconnect),
            1 => $discordAction->setUserRole($serverCommand->user, $verifiedUserRoleId, $onDoneConnect),
        };
    }
}
