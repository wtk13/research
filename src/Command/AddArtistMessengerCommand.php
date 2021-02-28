<?php

namespace App\Command;

use App\AggregateRoot\ArtistId;
use App\Message\CreateArtist;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Messenger\MessageBusInterface;

class AddArtistMessengerCommand extends Command
{
    protected static $defaultName = 'add-artist-messenger';
    protected static $defaultDescription = 'Add a short description for your command';

    private MessageBusInterface $messageBus;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription(self::$defaultDescription)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $this->messageBus->dispatch(
            new CreateArtist(
                new ArtistId(
                    Uuid::uuid4()->toString()
                )
            )
        );

        $io->success('Artist was created');
        return Command::SUCCESS;
    }
}
