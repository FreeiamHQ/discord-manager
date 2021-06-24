<?php

namespace App\DiscordCommands;

use Discord\Parts\Channel\Message;

class ConnectTwitterDiscordCommand
{
    public function execute(Message $discordMessage): void
    {
        $helpArticleLinkUrl = 'https://support.freeiam.com/twitter/connect.html';

        $discordMessage->channel
            ->sendMessage(
                "Connecting your Freeiam account with Twitter is **EASY**!\n\n" .
                "**Your benefits**:\n".
                "- Save Cards directly from Twitter\n".
                "- Create and start Challenges directly from Twitter\n".
                "Just follow these __quick 4 steps__ and you are done in no time: {$helpArticleLinkUrl}"
            );
    }
}
