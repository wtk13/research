<?php

namespace App\EventSubscriber;

use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Workflow\Event\Event;

class WorkflowLoggerSubscriber implements EventSubscriberInterface
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function onWorkflowWorkflowEnter(Event $event)
    {
        $this->logger->info(sprintf(
           'Blog post (id: "%s") performed transition "%s" from "%s" to "%s"',
           $event->getSubject()->getId(),
           $event->getTransition()->getName(),
           implode(', ', $event->getTransition()->getFroms()),
           implode(', ', $event->getTransition()->getTos())
       ));
    }

    public static function getSubscribedEvents()
    {
        return [
            'workflow.workflow.enter' => 'onWorkflowWorkflowEnter',
        ];
    }
}
