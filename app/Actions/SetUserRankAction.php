<?php

namespace App\Actions;

use App\DiscordAction;
use App\ServerCommand;

class SetUserRankAction
{
    public function execute(DiscordAction $discordAction, ServerCommand $serverCommand): void
    {
        $rankRoleId = config("discord.roles.ranks.{$serverCommand->value}");
        $rankDisplayName = ucfirst($serverCommand->value);

        $before = fn ($member) => collect(config('discord.ranks'))
            ->each(fn ($roleId) => $member->removeRole($roleId)); // Remove other rank roles

        $onDone = function ($member) use ($discordAction, $rankDisplayName) {
            $discordAction->botTalk("<@{$member->id}> has a new rank: {$rankDisplayName} 🎉");
        };

        $discordAction->setUserRole($serverCommand->user, $rankRoleId, $before, $onDone);
    }
}
