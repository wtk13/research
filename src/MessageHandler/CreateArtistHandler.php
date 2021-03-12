<?php

namespace App\MessageHandler;

use App\AggregateRoot\Artist;
use App\Message\CreateArtist;
use App\Repository\ArtistRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class CreateArtistHandler implements MessageHandlerInterface
{
    private ArtistRepository $artistRepository;

    public function __construct(ArtistRepository $artistRepository)
    {
        $this->artistRepository = $artistRepository;
    }

    public function __invoke(CreateArtist $message)
    {
        $artist = Artist::createArtist($message->artistId(), 25);

        $this->artistRepository->save($artist);
    }
}
