<?php

namespace App\Command;

use App\AggregateRoot\AdmissionId;
use App\AggregateRoot\Artist;
use App\Repository\ArtistRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CheckAdmissionQualityCommand extends Command
{
    protected static $defaultName = 'check-admission-quality';
    protected static $defaultDescription = 'Add a short description for your command';

    private ArtistRepository $artistRepository;

    public function __construct(ArtistRepository $artistRepository)
    {
        $this->artistRepository = $artistRepository;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription(self::$defaultDescription)
            ->addArgument('id', InputArgument::REQUIRED, 'Argument description')
            ->addArgument('admissionId', InputArgument::REQUIRED, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $id = $input->getArgument('id');
        $admissionId = $input->getArgument('admissionId');

        /** @var Artist $artist */
        $artist = $this->artistRepository->load($id);

        $artist->checkAdmissionQuality(
            new AdmissionId($admissionId)
        );

        $this->artistRepository->save($artist);

        $io->success(sprintf('Checked admission with id: %s', $admissionId));

        return Command::SUCCESS;
    }
}
