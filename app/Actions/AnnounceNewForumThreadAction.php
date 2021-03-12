<?php

namespace App\Actions;

use App\DiscordAction;
use App\ServerCommand;

class AnnounceNewForumThreadAction
{
    public function execute(DiscordAction $discordAction, ServerCommand $serverCommand): void
    {
        $publicUrl = $serverCommand->value;
        $discordUser = $serverCommand->user;
        $title = $serverCommand->meta['title'] ?? null;
        $userFirstName = $serverCommand->meta['userFirstName'] ?? null;
        $userUsername = $serverCommand->meta['userUsername'] ?? null;
        $userDisplayName = $userFirstName ? "{$userFirstName} ($userUsername)" : $userUsername;

        $authorDisplayName = $discordUser ? "<@{$discordUser}>" : $userDisplayName;

        $discordAction->botTalk("{$authorDisplayName} has started a new campfire 🪵🔥: {$title}. Join in! {$publicUrl}");
    }
}
