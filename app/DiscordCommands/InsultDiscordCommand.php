<?php

namespace App\DiscordCommands;

use Discord\Parts\Channel\Message;

class InsultDiscordCommand
{
    private $responses = [
        'You are an idiot ...',
        'Ass!',
        'Damn dawg, u actually kinda thic ngl... (didn not expect this one did you?)',
    ];

    public function execute(Message $discordMessage): void
    {
        $randomResponse = collect($this->responses)->random();

        $discordMessage->channel->sendMessage($randomResponse);
    }
}
