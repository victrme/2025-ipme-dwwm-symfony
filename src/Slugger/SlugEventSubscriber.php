<?php

namespace App\Slugger;

use App\Entity\Country;
use App\Slugger\SlugInterface;
use Doctrine\ORM\Events;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Symfony\Component\String\Slugger\AsciiSlugger;

#[AsDoctrineListener(event: Events::preUpdate, priority: 1, connection: "default")]
#[AsDoctrineListener(event: Events::prePersist, priority: 1, connection: "default")]
readonly final class SlugEventSubscriber
{
    public function preUpdate(PreUpdateEventArgs $eventArgs): void
    {
        $this->handle($eventArgs->getObject());
    }

    public function prePersist(PrePersistEventArgs $eventArgs): void
    {
        $this->handle($eventArgs->getObject());
    }

    private function handle(object $object): void
    {
        if ($object instanceof SlugInterface) {
            $slugger = new AsciiSlugger();
            $string = $object->getFields();
            $slug = $slugger->slug(strtolower($string));
            $object->setSlug($slug);
        }

        if ($object instanceof Country) {
            $object->setUrlFlag('https://flagcdn.com/32x24/' . $object->getCode() . '.png');
        }
    }
}
