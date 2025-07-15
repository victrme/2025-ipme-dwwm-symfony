<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Country;
use App\Entity\Game;
use App\Entity\Publisher;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GameType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options): void
	{
		$builder
			->add('name', null, ['attr' => ['class' => 'form-control']])
			->add('price', null, ['attr' => ['class' => 'form-control']])
			->add('description', null, ['attr' => ['class' => 'form-control']])
			->add('publishedAt', null, [
				'widget' => 'single_text',
				'attr' => ['class' => 'form-control'],
			])
			->add('thumbnailCover', null, ['attr' => ['class' => 'form-control']])
			->add(
				'publisher',
				EntityType::class,
				[
					'class' => Publisher::class,
					'choice_label' => 'name',
					'attr' => ['class' => 'form-control'],
				]
			)
			->add('categories', EntityType::class, [
				'class' => Category::class,
				'choice_label' => 'name',
				'multiple' => true,
				'expanded' => true,
			])
			->add('countries', EntityType::class, [
				'class' => Country::class,
				'choice_label' => 'name',
				'multiple' => true,
				'expanded' => true,
			])
			->add('submit', SubmitType::class, [
				'label' => 'CAM ARHCE',
				'attr' => ['class' => 'btn btn-primary'],
			])
		;
	}

	public function configureOptions(OptionsResolver $resolver): void
	{
		$resolver->setDefaults([
			'data_class' => Game::class,
		]);
	}
}
