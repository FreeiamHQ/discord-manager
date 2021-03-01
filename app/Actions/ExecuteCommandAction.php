<?php

namespace App\Actions;

use App\DiscordCommands\ConnectDiscordCommand;
use Discord\Parts\Channel\Message;
use App\DiscordCommands\InsultDiscordCommand;
use App\DiscordCommands\WelcomeDiscordCommand;

class ExecuteCommandAction
{
    public function __construct(
        private WelcomeDiscordCommand $welcomeDiscordCommand,
        private InsultDiscordCommand $insultDiscordCommand,
        private ConnectDiscordCommand $connectDiscordCommand,
    ) {}

    public function execute(string $command, Message $discordMessage): void
    {
        match ($command) {
            '!welcome' => $this->welcomeDiscordCommand->execute($discordMessage),
            '!insult' => $this->insultDiscordCommand->execute($discordMessage),
            '!connect' => $this->connectDiscordCommand->execute($discordMessage),
            default => '',
        };
    }
}
