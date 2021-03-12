<?php

return [
    'server-id' => env('DISCORD_SERVER_ID', '789622366946197544'),

    'channels' => [
        'bot-talk' => env('DISCORD_CHANNEL_BOTTALK', '796668796822618112'),
    ],

    'roles' => [
        'verified-user' => env('DISCORD_ROLE_VERIFIEDUSER', '820031168191528991'),
        'crypto-expert' => env('DISCORD_ROLE_CRYPTOEXPERT', '818829693385965582'),

        'ranks' => [
            'unranked' => env('DISCORD_ROLE_RANK_UNRANKED', '796488420637278249'),
            'sleeper' => env('DISCORD_ROLE_RANK_SLEEPER', '796488662355148810'),
            'seeker' => env('DISCORD_ROLE_RANK_SEEKER', '796488748447563786'),
            'believer' => env('DISCORD_ROLE_RANK_BELIEVER', '796488789522251806'),
            'dreamer' => env('DISCORD_ROLE_RANK_DREAMER', '796488836301455421'),
            'go-getter' => env('DISCORD_ROLE_RANK_GOGETTER', '796488925493461032'),
            'transcendent' => env('DISCORD_ROLE_RANK_TRANSCENDENT', '796488983571464212'),
        ],
    ],
];
