<?php

namespace App\DiscordCommands;

use Discord\Parts\Channel\Message;

class ConnectDiscordCommand
{
    public function execute(Message $discordMessage): void
    {
        $helpArticleLinkUrl = 'https://support.freeiam.com/discord/sync-rank.html';

        $discordMessage->channel
            ->sendMessage("Connecting your Freeiam account to Discord is easy!\nJust follow these quick 4 steps and you are done in no time: {$helpArticleLinkUrl}");
    }
}
