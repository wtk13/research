<?php

namespace App\Command;

use App\AggregateRoot\AdmissionId;
use App\AggregateRoot\Artist;
use App\AggregateRoot\ValueObject\Artwork;
use App\Repository\ArtistRepository;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class AddAdmissionToArtistCommand extends Command
{
    protected static $defaultName = 'add-admission-to-artist';
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
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $id = $input->getArgument('id');

        /** @var Artist $artist */
        $artist = $this->artistRepository->load($id);

        $admissionId = Uuid::uuid4();

        $artist->addAdmission(
            new AdmissionId(
                $admissionId
            ),
            new Artwork(1, 'FE')
        );

        $this->artistRepository->save($artist);

        $io->success(sprintf('Admission was created with id: %s', $admissionId));

        return Command::SUCCESS;
    }
}
