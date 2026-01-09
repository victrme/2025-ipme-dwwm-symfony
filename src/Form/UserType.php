<?php

namespace App\Form;

use App\Entity\Country;
use App\Entity\User;
use App\Repository\CountryRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $isRegistered = $options['isRegistered'];

        if ($isRegistered) {
            $builder
                ->add('email', EmailType::class, [
                    'attr' => [ // Définie les attributs HMTL de l'INPUT
                        'class' => 'form-control',
                    ],
                    'label_attr' => [
                        // Définie les attributs HMTL du LABEL
                    ]
                ])
                ->add('password', RepeatedType::class, [
                    'type' => PasswordType::class,
                    'first_options'  => [
                        'label' => 'Mot de passe',
                        'attr' => [
                            'class' => 'form-control',
                        ],
                    ],
                    'second_options' => [
                        'label' => 'Confirmez le mot de passe',
                        'attr' => [
                            'class' => 'form-control',
                        ],
                    ]
                ])
                ->add('name', null, [
                    'label' => 'Nom',
                    'attr' => [
                        'class' => 'form-control',
                    ]
                ]);
        } else {
            $builder->add('country', EntityType::class, [
                'class' => Country::class,
                'choice_label' => 'nationality', // propriété de la classe Country à afficher dans le select
                'query_builder' => function (CountryRepository $repo) { // OPTIONNEL : si vous voulez modifier l'ordre d'affichage dans le select...
                    return $repo->createQueryBuilder('c')
                        ->orderBy('c.nationality', 'ASC');
                }
            ]);
        }

        $builder
            ->add('nickname', null, [
                'label' => 'Pseudo',
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Valider mon inscription',
                'attr' => [
                    'class' => 'btn btn-primary mt-3',
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        // Type de "classe" qui sera gérée par ce formulaire (mettre null si aucune)
        $resolver->setDefaults([
            'data_class' => User::class, // App\Entity\User,
            'attr' => [ // Définie les attributs HMTL de la balise <form>
                'class' => 'form-steamish',
            ],
            // Ajoute une option FACULTATIVE à votre form
            'isRegistered' => true,
        ]);
    }
}
