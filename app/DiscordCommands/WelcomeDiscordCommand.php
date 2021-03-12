<?php

namespace App\DiscordCommands;

use Discord\Parts\Channel\Message;

class WelcomeDiscordCommand
{
    private $responses = [
        'Welcome - great to have you here!',
        'Hey Hey Hey!',
        'Hey you - where have you been all this time? 😨',
        'I am Ava, and who are you?',
        '👋 Hallo! 🇩🇪',
        '👋 Bonjour! 🇫🇷',
        '👋 Hola! 🇪🇸',
        '👋 Konnichiwa! 🇯🇵',
        '👋 Nǐn hǎo! 🇨🇳',
    ];

    public function execute(Message $discordMessage): void
    {
        $randomResponse = collect($this->responses)->random();

        $discordMessage->channel->sendMessage($randomResponse);
    }
}
