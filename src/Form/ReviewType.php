<?php

namespace App\Form;

use App\Entity\Review;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReviewType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options): void
	{
		$builder
			->add('content', null, [
				'label' => 'Message',
				'attr' => ['class' => 'form-control'],
			])
			->add('rating', IntegerType::class, [
				'label' => 'Note',
				'attr' => [
					'class' => 'form-control',
					'value' => 5,
					'min' => 1,
					'max' => 5,
				],
			])
			->add('submit', SubmitType::class, [
				'label' => 'Publier la review',
				'attr' => [
					'class' => 'btn btn-primary my-2',
				],
			])
		;
	}

	public function configureOptions(OptionsResolver $resolver): void
	{
		$resolver->setDefaults([
			'data_class' => Review::class,
		]);
	}
}
