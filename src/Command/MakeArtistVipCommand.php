<?php

namespace App\Command;

use App\AggregateRoot\Artist;
use App\Repository\ArtistRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class MakeArtistVipCommand extends Command
{
    protected static $defaultName = 'make-artist-vip';
    protected static $defaultDescription = 'Add a short description for your command';

    private ArtistRepository $artistRepository;

    public function __construct(ArtistRepository $artistRepository)
    {
        $this->artistRepository = $artistRepository;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription(self::$defaultDescription)
            ->addArgument('id', InputArgument::REQUIRED, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $id = $input->getArgument('id');

        /** @var Artist $artist */
        $artist = $this->artistRepository->load($id);

        $artist->makeVip();

        $this->artistRepository->save($artist);

        $io->success(sprintf('Artist made as vip with id: %s', $artist->getAggregateRootId()));

        return Command::SUCCESS;
    }
}
