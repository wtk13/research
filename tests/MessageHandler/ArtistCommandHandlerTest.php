<?php

namespace App\Tests\MessageHandler;

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
        $artistRepository = new ArtistRepository($eventStore, $eventBus);

        return new class($artistRepository) extends CreateArtistHandler implements CommandHandler {
            public function __construct(ArtistRepository $artistRepository)
            {
                parent::__construct($artistRepository);
            }

            public function handle($command): void
            {
                $this->__invoke($command);
            }
        };
    }
}
