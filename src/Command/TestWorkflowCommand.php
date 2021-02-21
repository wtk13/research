<?php

namespace App\Command;

use App\Repository\WorkflowRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Workflow\WorkflowInterface;

class TestWorkflowCommand extends Command
{
    protected static $defaultName = 'test-workflow';
    protected static $defaultDescription = 'Add a short description for your command';

    /**
     * @var WorkflowInterface
     */
    private $workflow;

    /**
     * @var WorkflowRepository
     */
    private $workflowRepository;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(WorkflowInterface $workflowStateMachine, WorkflowRepository $workflowRepository, EntityManagerInterface $entityManager)
    {
        $this->workflow = $workflowStateMachine;
        $this->workflowRepository = $workflowRepository;
        $this->entityManager = $entityManager;

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
        $workflow = $this->workflowRepository->find(1);

        dump($workflow);

        dump($this->workflow->apply($workflow, 'publish'));

        $this->entityManager->flush();

        return Command::SUCCESS;
    }
}
