<?php

namespace App\Form;

use App\Entity\ParentEntity;
use App\Subscriber\ReindexDoctrineCollectionListener;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ParentEntityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('prop1')
            ->add('childEntities',CollectionType::class,[
              'entry_type' => ChildEntityType::class,
              'allow_add' => true,
              'allow_delete' => true,
              'by_reference' => false,
            ])
        ;
          
        $builder->addEventSubscriber(new ReindexDoctrineCollectionListener(['childEntities']));        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ParentEntity::class,
        ]);
    }
}
