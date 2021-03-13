<?php

namespace App\DiscordCommands;

use App\DiscordAction;
use Discord\Parts\Channel\Message;

class CryptoExpertCommand
{
    private $responses = [
        'Crypto expert found 🚨 You have now access to the Freeiam crypto channels 🎉',
        'Guess who now has access to the crypto channels? You! 🎉'
    ];

    private $alreadyHasRoleResponses = [
        'Stop kidding me! You already have the crypto expert role...',
        'You already have the crypto expert role 😒',
        'You already are a crypto expert... I won\'t assign you twice!',
    ];

    public function execute(Message $discordMessage, DiscordAction $discordAction): void
    {
        $cryptoRoleId = config('discord.roles.crypto-expert');
        $discordUserId = $discordMessage->author->id;

        if ($discordMessage->author->roles->has($cryptoRoleId)) {
            $discordAction->botTalk(collect($this->alreadyHasRoleResponses)->random(), $discordUserId);
            return;
        }

        $discordAction->setUserRole($discordUserId, $cryptoRoleId, function () use ($discordAction, $discordUserId) {
            $discordAction->botTalk(collect($this->responses)->random(), $discordUserId);
        });
    }
}
