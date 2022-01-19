<?php

namespace App\DiscordCommands;

use Discord\Parts\Channel\Message;

class ConnectDiscordCommand
{
    public function execute(Message $discordMessage): void
    {
        $helpArticleLinkUrl = 'https://support.freeiam.com/discord/sync-account.html';

        $discordMessage->channel
            ->sendMessage(
                "Connecting your Freeiam account with Discord is **EASY**!\n\n" .
                "**Your benefits**:\n".
                "- Get your "Superhuman" tag here!\n".
                "- Sync your Freeiam rank\n".
                "- Auto-publish your campfires\n".
                "- Auto-publish achieved 💯's\n\n".
                "Just follow these __quick 4 steps__ and you are done in no time: {$helpArticleLinkUrl}"
            );
    }
}
