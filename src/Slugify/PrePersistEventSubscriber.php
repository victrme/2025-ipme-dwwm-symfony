<?php

namespace App\Slugify;

use App\Entity\Country;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;

#[AsDoctrineListener(event: Events::preUpdate, priority: 500, connection: 'default')]
#[AsDoctrineListener(event: Events::prePersist, priority: 500, connection: 'default')]
readonly class PrePersistEventSubscriber
{

    public function __construct(private SlugService $slugService)
    {
    }

    public function preUpdate(PreUpdateEventArgs $eventArgs): void {
        $this->handle($eventArgs->getObject());
    }

    public function prePersist(PrePersistEventArgs $eventArgs): void {
        $this->handle($eventArgs->getObject());
    }

    private function handle(object $object): void {
        if ($object instanceof SlugInterface) {
            $object->setSlug($this->slugService->slugify($object->getName()));
        }

        if ($object instanceof Country) {
            $object->setUrlFlag('https://flagcdn.com/32x24/'.$object->getCode().'.png');
        }
    }

}
