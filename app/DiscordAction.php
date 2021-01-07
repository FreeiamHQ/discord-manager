<?php

namespace App;

use Discord\Discord;
use InvalidArgumentException;
use Discord\Parts\Guild\Guild;
use Discord\Parts\User\Member;
use Discord\Parts\Channel\Channel;
use Discord\Parts\Channel\Message;

class DiscordAction
{
    public function __construct(
        private Discord $client,
    ) {}

    public function addRoleToUser(string $user, ?string $role): void
    {
        throw_unless($role, InvalidArgumentException::class, 'Role is required.');

        $client = $this->client;

        $client->guilds
            ->fetch(env('DISCORD_SERVER_ID'))
            ->done(function (Guild $guild) use ($user, $role, $client) {
                $guild->members->fetch($user)->done(function (Member $member) use ($role, $client) {

                    collect(config('discord.ranks'))
                        ->each(fn ($roleId) => $member->removeRole($roleId));

                    $member->addRole($role);

                    $client->guilds->save($member);
                });
            });
    }

    public function sendMessage(Channel $channel, string $message): void
    {
        $message = new Message($this->client);
        $message->content = $message;
        $channel->sendMessage($message);
    }
}
