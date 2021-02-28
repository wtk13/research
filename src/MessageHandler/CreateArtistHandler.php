<?php

namespace App\MessageHandler;

use App\AggregateRoot\Artist;
use App\AggregateRoot\ArtistId;
use App\CommandBus;
use App\Message\CreateArtist;
use App\Repository\ArtistRepository;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class CreateArtistHandler extends CommandBus implements MessageHandlerInterface
{
    private ArtistRepository $artistRepository;

    public function __construct(ArtistRepository $artistRepository, iterable $middlewareHandlers = [])
    {
        $this->artistRepository = $artistRepository;

        parent::__construct($middlewareHandlers);
    }

    public function __invoke(CreateArtist $message)
    {
        $artistId = new ArtistId(
            Uuid::uuid4()->toString()
        );

        $artist = Artist::createArtist($artistId);

        $this->artistRepository->save($artist);
    }

    public function handle($command): void
    {
        $this->__invoke($command);
    }
}
