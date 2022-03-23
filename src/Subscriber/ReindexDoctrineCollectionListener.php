<?php
namespace App\Subscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * Resize a collection form element based on the data sent from the client.
 *
 * @author Bernhard Schussek <bschussek@gmail.com>
 */
class ReindexDoctrineCollectionListener implements EventSubscriberInterface
{
    protected $paths;

    public function __construct(array $paths = [])
    {
        $this->paths = $paths;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            FormEvents::SUBMIT => 'onSubmit',
        ];
    }


    public function onSubmit(FormEvent $event)
    {
        $form = $event->getForm();
        $data = $event->getData();

        if (null === $data) {
            return;
        }

        $propertyAccessor = PropertyAccess::createPropertyAccessor();

        foreach ($this->paths as $path) {
            $dc = $propertyAccessor->getValue($data, $path);
            if (!\is_array($dc) && !($dc instanceof \Doctrine\ORM\PersistentCollection)) {
                throw new UnexpectedTypeException($dc, 'Doctrine\ORM\PersistentCollection');
            }

            $dcUnkeyed = array_values($dc->toArray());
            $dc->clear();

            $keys = [];
            foreach ($form[$path] as $key => $value) {
              $keys[] = $key;
            }

            foreach ($dcUnkeyed as $i => $value) {
              $dc->set($keys[$i], $value);
            }
        }
    }
}