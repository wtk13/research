<?php

declare(strict_types=1);

namespace App\Repository;

use App\AggregateRoot\Artist;
use Broadway\EventHandling\EventBus;
use Broadway\EventSourcing\AggregateFactory\PublicConstructorAggregateFactory;
use Broadway\EventSourcing\EventSourcingRepository;
use Broadway\EventStore\EventStore;

class ArtistRepository extends EventSourcingRepository
{
    public function __construct(
        EventStore $eventStore,
        EventBus $eventBus,
     array $eventStreamDecorators = []
    ) {
        parent::__construct(
            $eventStore,
            $eventBus,
            Artist::class,
            new PublicConstructorAggregateFactory(),
            $eventStreamDecorators
        );
    }
}
