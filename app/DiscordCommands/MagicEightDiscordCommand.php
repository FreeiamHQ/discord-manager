<?php

namespace App\DiscordCommands;

use Discord\Parts\Channel\Message;

class MagicEightDiscordCommand
{
    private $responses = [
        'Yes!',
        'No!',
        'Yes definitely!',
        'No wtf?!',
        'For sure!',
        'Nope...',
        'Nope!',
        '👍',
        '👎',
        'Ask someone else!',
    ];

    public function execute(Message $discordMessage): void
    {
        $randomResponse = collect($this->responses)->random();

        $discordMessage->channel->sendMessage($randomResponse);
    }
}
