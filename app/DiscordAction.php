<?php

namespace App;

use Discord\Discord;
use InvalidArgumentException;
use Discord\Parts\Guild\Guild;
use Discord\Parts\User\Member;

class DiscordAction
{
    public function __construct(
        private Discord $client,
    ) {}

    public function setUserRole(string $user, ?string $role, ?Callable $onDoneAction = null, ?Callable $beforeAction = null): void
    {
        throw_unless($role, InvalidArgumentException::class, 'Role is required.');

        $client = $this->client;

        $client->guilds
            ->fetch(config('discord.server-id'))
            ->done(function (Guild $guild) use ($user, $role, $client, $onDoneAction, $beforeAction) {
                $guild->members->fetch($user)->done(function (Member $member) use ($guild, $role, $client, $onDoneAction, $beforeAction) {

                    if ($beforeAction) $beforeAction($member, $guild);

                    $member->addRole($role)->done(function () use ($client, $onDoneAction, $member, $guild) {
                        $client->guilds->save($member);
                        if ($onDoneAction) $onDoneAction($member, $guild);
                    });
                });
            });
    }

    public function botTalk(string $message, ?string $discordUserId = null): void
    {
        $finalMessage = $discordUserId ? "<@{$discordUserId}> {$message}" : $message;

        $this->client
            ->getChannel(config('discord.channels.bot-talk'))
            ->sendMessage($finalMessage);
    }
}
