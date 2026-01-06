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
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GameType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'label' => 'game.properties.name',
            ])
            ->add('price', null, [
                'label' => 'game.properties.price',
            ])
            ->add('description', TextareaType::class, [
                'label' => 'game.properties.description',
            ])
            ->add('publishedAt', null, [
                'label' => 'game.properties.publishedAt',
                'widget' => 'single_text',
            ])
            ->add('publisher', EntityType::class, [
                'label' => 'game.properties.publisher',
                'class' => Publisher::class,
                'choice_label' => 'name',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('p')
                        ->orderBy('p.name', 'ASC');
                },
            ])
            ->add('countries', CollectionType::class, [
                'label' => 'game.properties.countries',
                'entry_type' => EntityType::class,
                'entry_options' => [
                    'label' => false,
                    'class' => Country::class,
                    'choice_label' => 'nationality',
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('p')
                            ->orderBy('p.nationality', 'ASC');
                    }
                ],
                'attr' => [
                    'data-list-selector' => 'countries',
                ],
                'allow_add' => true,
                'allow_delete' => true,
            ])
            ->add('btnAddCountry', AddButtonCollectionType::class, [
                'data-btn-selector' => 'countries',
                'mapped' => false,
                'label' => false,
            ])
            ->add('categories', CollectionType::class, [
                'label' => 'game.properties.categories',
                'entry_type' => EntityType::class,
                'entry_options' => [
                    'label' => false,
                    'class' => Category::class,
                    'choice_label' => 'name',
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('p')
                            ->orderBy('p.name', 'ASC');
                    }
                ],
                'attr' => [
                    'data-list-selector' => 'categories',
                ],
                'allow_add' => true,
                'allow_delete' => true,
            ])
            ->add('btnAddCategory', AddButtonCollectionType::class, [
                'data-btn-selector' => 'categories',
                'mapped' => false,
                'label' => false,
            ])
            ->add('thumbnailCover', FileType::class, [
                'label' => 'game.properties.thumbnailCover',
                'mapped' => false,
                'required' => false,
            ])
            ->add('thumbnailCoverLink', null, [
                'label' => 'game.properties.thumbnailCoverLink',
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Créer',
                'attr' => [
                    'class' => 'btn btn-primary',
                ]
            ]);

// TODO : exemple d'un FormEvent

//        $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event): void {
//            $form = $event->getForm();
//
//            $field = $form->get('thumbnailCover');
//            $fieldLink = $form->get('thumbnailCoverLink');
//
//            if ($field->getData() === null && $fieldLink->getData() === null) {
//                $form->addError(new FormError('MET AU MOINS UNE IMAGE'));
//            }
//        });

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Game::class,
            'translation_domain' => 'admin',
        ]);
    }
}
