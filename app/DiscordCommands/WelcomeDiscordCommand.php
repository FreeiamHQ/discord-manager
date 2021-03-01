<?php

namespace App\DiscordCommands;

use Discord\Parts\Channel\Message;

class WelcomeDiscordCommand
{
    private $responses = [
        'Welcome - great to have you here!',
        'Hey Hey Hey!',
    ];

    public function execute(Message $discordMessage): void
    {
        $randomResponse = collect($this->responses)->random();

        $discordMessage->channel->sendMessage($randomResponse);
    }
}
