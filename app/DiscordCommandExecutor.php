<?php

namespace App;

use Discord\Discord;
use Discord\Parts\Channel\Message;
use App\DiscordCommands\HelpDiscordCommand;
use App\DiscordCommands\InsultDiscordCommand;
use App\DiscordCommands\ConnectDiscordCommand;
use App\DiscordCommands\ConnectTwitterDiscordCommand;
use App\DiscordCommands\WelcomeDiscordCommand;
use App\DiscordCommands\MagicEightDiscordCommand;
use App\DiscordCommands\CryptoExpertDiscordCommand;

class DiscordCommandExecutor
{
    public function __construct(
        private WelcomeDiscordCommand $welcomeDiscordCommand,
        private InsultDiscordCommand $insultDiscordCommand,
        private ConnectDiscordCommand $connectDiscordCommand,
        private ConnectTwitterDiscordCommand $connectTwitterDiscordCommand,
        private CryptoExpertDiscordCommand $cryptoExpertCommand,
        private HelpDiscordCommand $helpDiscordCommand,
        private MagicEightDiscordCommand $magicEightDiscordCommand,
    ) {}

    public function execute(string $command, Message $discordMessage, Discord $discord): void
    {
        $discordAction = new DiscordAction($discord);

        match ($command) {
            '!welcome' => $this->welcomeDiscordCommand->execute($discordMessage),
            '!insult' => $this->insultDiscordCommand->execute($discordMessage),
            '!connect' => $this->connectDiscordCommand->execute($discordMessage),
            '!twitter' => $this->connectTwitterDiscordCommand->execute($discordMessage),
            '!crypto' => $this->cryptoExpertCommand->execute($discordMessage, $discordAction),
            '!help', '!commands' => $this->helpDiscordCommand->execute($discordAction),
            '!magic8', '!yn' => $this->magicEightDiscordCommand->execute($discordMessage),
            default => '',
        };
    }
}
