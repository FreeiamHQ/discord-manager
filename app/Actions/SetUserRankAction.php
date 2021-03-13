<?php

namespace App\Actions;

use App\AppColor;
use App\DiscordAction;
use App\ServerCommand;
use Discord\Parts\Guild\Guild;
use Discord\Parts\User\Member;

class SetUserRankAction
{
    public function execute(DiscordAction $discordAction, ServerCommand $serverCommand): void
    {
        $rankRoleId = config("discord.roles.ranks.{$serverCommand->value}");
        $isUpgrade = $serverCommand->getMeta('type') === 'promotion';
        $rankDisplayName = $serverCommand->getMeta('rankName');
        $rankImageUrl = $serverCommand->getMeta('rankImageUrl');

        // Remove other rank roles
        $before = function (Member $member, Guild $guild) {
            collect(config('discord.roles.ranks'))->each(fn ($roleId) => $member->removeRole($roleId));
            return [$member, $guild];
        };

        $onDone = function ($member) use ($discordAction, $isUpgrade, $rankDisplayName, $rankImageUrl) {
            $discordAction->botTalkWithEmbed(
                message: "<@{$member->id}> has a new rank " . ($isUpgrade ? '🎉' : '...'),
                color: $isUpgrade ? AppColor::ThemeGreen : AppColor::ThemeRed,
                title: $rankDisplayName,
                description: $isUpgrade ? 'Upgrade ✅' : 'Downgrade ❌',
                thumbnailUrl: $rankImageUrl,
            );
        };

        $discordAction->setUserRole($serverCommand->user, $rankRoleId, $onDone, $before);
    }
}
