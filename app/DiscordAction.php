<?php

namespace App;

use Discord\Discord;
use InvalidArgumentException;
use Discord\Parts\Embed\Embed;
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
                    if ($member->roles->has($role)) return;
                    if ($beforeAction) $beforeAction($member, $guild);

                    $member->addRole($role)->done(function () use ($client, $onDoneAction, $member, $guild) {
                        $client->guilds->save($member);
                        if ($onDoneAction) $onDoneAction($member, $guild);
                    });
                });
            });
    }

    public function removeUserRole(string $user, ?string $role, ?Callable $onDoneAction = null, ?Callable $beforeAction = null): void
    {
        throw_unless($role, InvalidArgumentException::class, 'Role is required.');

        $client = $this->client;

        $client->guilds
            ->fetch(config('discord.server-id'))
            ->done(function (Guild $guild) use ($user, $role, $client, $onDoneAction, $beforeAction) {
                $guild->members->fetch($user)->done(function (Member $member) use ($guild, $role, $client, $onDoneAction, $beforeAction) {
                    if (!$member->roles->has($role)) return;
                    if ($beforeAction) $beforeAction($member, $guild);

                    $member->removeRole($role)->done(function () use ($client, $onDoneAction, $member, $guild) {
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

    public function botTalkWithEmbed(?string $message = null, string $color, string $title, ?string $description = null, array $fields = [], ?string $thumbnailUrl = null, ?string $imageUrl = null, ?string $footerText = null, ?string $discordUserId = null): void
    {
        $finalTitle = $discordUserId ? "<@{$discordUserId}> {$title}" : $title;

        $embed = (new Embed($this->client))
            ->setTitle($finalTitle)
            ->setColor(strtolower(str_replace('#', '0x', $color)))
            ->setThumbnail($thumbnailUrl ?? 'https://www.freeiam.com/images/logo.png');

        collect($fields)
            ->each(fn (DiscordFieldValue $field) => $embed->addFieldValues($field->name, $field->value, $field->inline));

        if ($description) $embed->setDescription($description);
        if ($imageUrl) $embed->setImage($imageUrl);
        if ($footerText) $embed->setFooter($footerText);

        $channel = $this->client->getChannel(config('discord.channels.bot-talk'));

        $message
            ? $channel->sendMessage($message, false, $embed)
            : $channel->sendEmbed($embed);
    }

    public function getClient(): Discord
    {
        return $this->client;
    }
}
