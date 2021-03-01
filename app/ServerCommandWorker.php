<?php

namespace App;

use Discord\Discord;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Actions\ExecuteServerCommandAction;

class ServerCommandWorker
{
    const ApiEndpoint = 'discord-manager/queue';

    public function __construct(
        private ExecuteServerCommandAction $executeServerCommandAction
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
                ->each(fn ($commandData) => $this->executeServerCommandAction->execute(ServerCommand::fromArray($commandData), $discord));
    }
}
