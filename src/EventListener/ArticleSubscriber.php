<?php

namespace App\EventListener;

use Acme\Article\Model\ArticleCreatedEvent;
use Acme\PostCount\UseCase\RecordPostCount;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ArticleSubscriber implements EventSubscriberInterface
{
    /**
     * @var RecordPostCount
     */
    private $recordPostCount;

    public function __construct(RecordPostCount $recordPostCount)
    {
        $this->recordPostCount = $recordPostCount;
    }

    public function onCreated(ArticleCreatedEvent $event): void
    {
        ($this->recordPostCount)(new \DateTime());
    }

    public static function getSubscribedEvents(): array
    {
        return [
            ArticleCreatedEvent::class => ['onCreated'],
        ];
    }
}
