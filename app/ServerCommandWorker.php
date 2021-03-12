<?php

namespace App;

use Discord\Discord;
use App\ServerCommandExecutor;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class ServerCommandWorker
{
    const ApiEndpoint = 'discord-manager/queue';

    public function __construct(
        private ServerCommandExecutor $serverCommandExecutor
    ) {}

    public function run(Discord $discord): void
    {
        $res = Http::withToken(env('API_TOKEN'))
            ->timeout(5)
            ->acceptJson()
            ->get(env('API_URL') . '/' . self::ApiEndpoint);

            if ($res->failed()) {
                Log::error('Did not get a successful response from server discord queue.');
                return;
            }

            collect($res->json()['data'] ?? [])
                ->reverse()
                ->each(fn ($commandData) => $this->serverCommandExecutor->execute(ServerCommand::fromArray($commandData), $discord));
    }
}
