<?php

namespace App\DiscordCommands;

use Discord\Parts\Channel\Message;

class ConnectDiscordCommand
{
    public function execute(Message $discordMessage): void
    {
        $helpArticleLinkUrl = 'https://law.superciety.com/superhuman/discord.html';

        $discordMessage->channel
            ->sendMessage(
                "Connecting your Freeiam account with Discord is **EASY**!\n\n" .
                "**Your benefits**:\n".
                "- Get the 'Superhuman' Discord role\n".
                "- Sync your Freeiam rank (Discord role)\n".
                "- Auto-publish your campfires\n".
                "- Auto-publish achieved 💯's\n\n".
                "Just follow these __quick 4 steps__ and you are done in no time: {$helpArticleLinkUrl}"
            );
    }
}
