<?php

namespace App\Command;

use App\AggregateRoot\Artist;
use App\AggregateRoot\ArtistId;
use App\Repository\ArtistRepository;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class AddArtistCommand extends Command
{
    protected static $defaultName = 'add-artist';
    protected static $defaultDescription = 'Add a short description for your command';

    /**
     * @var ArtistRepository
     */
    private $artistRepository;

    public function __construct(ArtistRepository $artistRepository)
    {
        $this->artistRepository = $artistRepository;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription(self::$defaultDescription)
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $artistId = new ArtistId(
            Uuid::uuid4()->toString()
        );

        $artist = Artist::createArtist($artistId);

        $this->artistRepository->save($artist);

        $io->success(sprintf('Artist was created with id: %s', $artist->getAggregateRootId()));

        return Command::SUCCESS;
    }
}
