<?php

namespace App;

use Discord\Discord;
use Discord\Parts\Channel\Message;
use App\DiscordCommands\CryptoExpertCommand;
use App\DiscordCommands\InsultDiscordCommand;
use App\DiscordCommands\ConnectDiscordCommand;
use App\DiscordCommands\WelcomeDiscordCommand;

class CommandExecutor
{
    public function __construct(
        private WelcomeDiscordCommand $welcomeDiscordCommand,
        private InsultDiscordCommand $insultDiscordCommand,
        private ConnectDiscordCommand $connectDiscordCommand,
        private CryptoExpertCommand $cryptoExpertCommand,
    ) {}

    public function execute(string $command, Message $discordMessage, Discord $discord): void
    {
        $discordAction = new DiscordAction($discord);

        match ($command) {
            '!welcome' => $this->welcomeDiscordCommand->execute($discordMessage),
            '!insult' => $this->insultDiscordCommand->execute($discordMessage),
            '!connect' => $this->connectDiscordCommand->execute($discordMessage),
            '!crypto' => $this->cryptoExpertCommand->execute($discordMessage, $discordAction),
            default => '',
        };
    }
}
