<?php

namespace App\Tests\Message;

use App\MessageHandler\CreateArtistHandler;
use App\Repository\ArtistRepository;
use Broadway\CommandHandling\CommandHandler;
use Broadway\CommandHandling\Testing\CommandHandlerScenarioTestCase;
use Broadway\EventHandling\EventBus;
use Broadway\EventStore\EventStore;

abstract class ArtistCommandHandlerTest extends CommandHandlerScenarioTestCase
{
    protected function createCommandHandler(EventStore $eventStore, EventBus $eventBus): CommandHandler
    {
        return new CreateArtistHandler(
            new ArtistRepository($eventStore, $eventBus)
        );
    }
}
