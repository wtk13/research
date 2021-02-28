<?php

declare(strict_types=1);

namespace App;

use Broadway\CommandHandling\CommandHandler;
use Symfony\Component\Messenger\MessageBus;

class CommandBus extends MessageBus implements CommandHandler
{
    public function handle($command): void
    {
        parent::dispatch($command);
    }
}
