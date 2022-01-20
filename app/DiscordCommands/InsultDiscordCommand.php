<?php

namespace App\DiscordCommands;

use Discord\Parts\Channel\Message;

class InsultDiscordCommand
{
    private $responses = [
        'I am Ava. I don\'t curse 😠',
    ];

    public function execute(Message $discordMessage): void
    {
        $randomResponse = collect($this->responses)->random();

        $discordMessage->channel->sendMessage($randomResponse);
    }
}
