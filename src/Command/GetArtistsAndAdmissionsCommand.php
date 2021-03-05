<?php

namespace App\Command;

use Broadway\ReadModel\Repository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class GetArtistsAndAdmissionsCommand extends Command
{
    protected static $defaultName = 'get-artists-and-admissions';
    protected static $defaultDescription = 'Add a short description for your command';
    private Repository $repository;

    public function __construct(Repository $artistToValidateRepository, string $name = null)
    {
        $this->repository = $artistToValidateRepository;

        parent::__construct($name);
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

        $result = $this->repository->find('915c071f-50ed-4594-80e7-fec57277df02');

        dump($result);
        die;

        return Command::SUCCESS;
    }
}
