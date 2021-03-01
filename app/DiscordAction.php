<?php

namespace App;

use Discord\Discord;
use InvalidArgumentException;
use Discord\Parts\Guild\Guild;
use Discord\Parts\User\Member;
use Discord\Parts\Channel\Channel;

class DiscordAction
{
    public function __construct(
        private Discord $client,
    ) {}

    public function addRoleToUser(string $user, ?string $role, ?string $rankDisplayName): void
    {
        throw_unless($role, InvalidArgumentException::class, 'Role is required.');

        $client = $this->client;

        $client->guilds
            ->fetch(env('DISCORD_SERVER_ID'))
            ->done(function (Guild $guild) use ($user, $role, $client, $rankDisplayName) {
                $guild->members->fetch($user)->done(function (Member $member) use ($guild, $role, $client, $rankDisplayName) {
                    // Manage role
                    collect(config('discord.ranks'))
                        ->each(fn ($roleId) => $member->removeRole($roleId));

                    $member->addRole($role);
                    $client->guilds->save($member);

                    // Send confirmation message
                    $guild->channels->fetch(config('discord.notification_channel_id'))->done(function (Channel $channel) use($member, $rankDisplayName) {
                        $rankNameFormatted = strtoupper($rankDisplayName);
                        $channel->sendMessage("<@{$member->id}> has a new rank: {$rankNameFormatted} 🎉");
                    });
                });
            });
    }

    public function sendMessageToNotificationChannel(string $message): void
    {
        $this->client
            ->getChannel(config('discord.notification_channel_id'))
            ->sendMessage($message);
    }
}
