<?php

namespace App\Commands;

use Exception;
use Discord\Discord;
use App\ServerCommandWorker;
use Discord\Parts\Channel\Message;
use App\Actions\ExecuteCommandAction;
use LaravelZero\Framework\Commands\Command;

class StartCommand extends Command
{
    protected $signature = 'freeiam:start';

    protected $description = 'Starts the Bot.';

    const ServerWorkerExecutionTimeoutInSeconds = 60 * 5;

    public function handle()
    {
        $loop = \React\EventLoop\Factory::create();

        $discord = new Discord([
            'token' => env('DISCORD_TOKEN') ?? throw new Exception('Discord is not configured.'),
            'loop' => $loop,
        ]);

        $discord->on('message', function (Message $message) {
            if (str_starts_with($message->content, '!')) {
                resolve(ExecuteCommandAction::class)->execute(strtolower($message->content), $message);
            }
        });

        $loop->addPeriodicTimer(static::ServerWorkerExecutionTimeoutInSeconds, function () use ($discord) {
            resolve(ServerCommandWorker::class)->run($discord);
        });

        $discord->run();
    }
}
