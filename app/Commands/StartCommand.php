<?php

namespace App\Commands;

use Exception;
use Discord\Discord;
use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class StartCommand extends Command
{
    protected $signature = 'freeiam:start';

    protected $description = 'Starts the Bot.';

    public function handle()
    {
        $discord = new Discord([
            'token' => env('DISCORD_TOKEN') ?? throw new Exception('Discord is not configured.'),
        ]);

        $discord->on('ready', function (Discord $discord) {

        });

        $discord->run();
    }

    public function schedule(Schedule $schedule): void
    {
    }
}
