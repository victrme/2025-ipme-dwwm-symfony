<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options): void
	{
		$builder

			->add('name', null, [
				'label' => 'Nom de la Catégorie',
				'attr' => [
					'class' => 'form-control',
				],
			])
			->add('slug', null, [
				'label' => 'Chemin vers la catégorie',
				'attr' => [
					'class' => 'form-control',
				],
			])
			->add('save', SubmitType::class, [
				'label' => 'Save',
				'attr' => [
					'class' => 'btn btn-primary mt-3',
				],
			]);
		// ->add('image', FileType::class, [
		//     "label" => "Upload Image",
		//     "attr" => [
		//         "class" => "form-control"
		//     ]
		// ])
		// ->add('games', EntityType::class, [
		//     'class' => Game::class,
		//     'choice_label' => 'id',
		//     'multiple' => true,
		// ])
	}

	public function configureOptions(OptionsResolver $resolver): void
	{
		$resolver->setDefaults([
			'data_class' => Category::class,
		]);
	}
}
