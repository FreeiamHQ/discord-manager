<?php

namespace App\Commands;

use Exception;
use Discord\Discord;
use Illuminate\Support\Facades\Http;
use App\Actions\ExecuteCommandAction;
use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class QueueCommand extends Command
{
    protected $signature = 'freeiam:queue';

    protected $description = 'Fetch and execute commands retrieved from the Freeiam API.';

    const ApiEndpoint = 'discord-manager-queue';

    public function handle(ExecuteCommandAction $executeCommandAction)
    {
        $discord = new Discord([
            'token' => env('DISCORD_TOKEN') ?? throw new Exception('Discord is not configured.'),
        ]);

        $res = Http::withToken(env('API_TOKEN'))
            ->timeout(5)
            ->get(env('API_URL') . '/' . self::ApiEndpoint);

        if ($res->failed()) {
            return;
        }

        collect($res->json()['data'] ?? [])
            ->each(fn ($commandData) => $executeCommandAction->execute(Command::fromArray($commandData), $discord));
    }

    public function schedule(Schedule $schedule): void
    {
        $schedule->command(static::class)->everyTenMinutes();
    }
}
