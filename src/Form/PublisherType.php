<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Country;
use App\Entity\Game;
use App\Entity\Publisher;
use App\Form\Component\AddButtonCollectionType;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PublisherType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'label' => 'publisher.properties.name',
            ])
            ->add('createdAt', null, [
                'widget' => 'single_text',
                'label' => 'publisher.properties.createdAt',
            ])
            ->add('website', null, [
                'label' => 'publisher.properties.website',
            ])
            ->add('country', EntityType::class, [
                'label' => 'publisher.properties.country',
                'class' => Country::class,
                'choice_label' => 'name',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.name', 'ASC');
                }
            ]);

        if ($options['isWithFullInformation']) {
            $builder
                ->add('games', CollectionType::class, [
                    'label' => 'publisher.properties.games',
                    'entry_type' => EntityType::class,
                    'entry_options' => [
                        'label' => false,
                        'class' => Game::class,
                        'choice_label' => 'name',
                        'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('g')
                                ->orderBy('g.name', 'ASC');
                        }
                    ],
                    'attr' => [
                        'data-list-selector' => 'games',
                    ],
                    'allow_add' => true,
                    'allow_delete' => true,
                ])
                ->add('btnAddGames', AddButtonCollectionType::class, [
                    'data-btn-selector' => 'games',
                    'mapped' => false,
                    'label' => false,
                ])
                ->add('submit', SubmitType::class, [
                    'label' => 'Créer',
                    'attr' => [
                        'class' => 'btn btn-primary',
                    ]
                ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Publisher::class,
            'translation_domain' => 'admin',
            'isWithFullInformation' => true,
        ]);
    }
}
