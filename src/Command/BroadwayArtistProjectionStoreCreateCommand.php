<?php

namespace App\Command;

use App\ReadModel\ArtistToValidateRepository;
use Doctrine\DBAL\Connection;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class BroadwayArtistProjectionStoreCreateCommand extends Command
{
    protected static $defaultName = 'broadway:artist-projection-store:create';
    protected static $defaultDescription = 'Add a short description for your command';

    private Connection $connection;
    private ArtistToValidateRepository $artistToValidateRepository;

    public function __construct(Connection $connection, ArtistToValidateRepository $artistToValidateRepository)
    {
        $this->connection = $connection;
        $this->artistToValidateRepository = $artistToValidateRepository;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription(self::$defaultDescription)
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $schemaManager = $this->connection->getSchemaManager();

        if ($table = $this->artistToValidateRepository->configureSchema($schemaManager->createSchema())) {
            $schemaManager->createTable($table);
            $output->writeln('<info>Created Broadway artist projection store schema</info>');
        } else {
            $output->writeln('<info>Broadway artist projection store schema already exists</info>');
        }

        return Command::SUCCESS;
    }
}
