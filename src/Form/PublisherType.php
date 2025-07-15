<?php

namespace App\Form;

use App\Entity\Country;
use App\Entity\Publisher;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PublisherType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options): void
	{
		$builder
			// ->add('createdAt', null, [
			//     'widget' => 'single_text',
			// ])
			->add('name', null, [
				'label' => 'Nom',
				'attr' => ['class' => 'form-control'],
			])
			->add('website', UrlType::class, [
				'label' => 'Site web',
				'attr' => ['class' => 'form-control'],
			])
			->add('country', EntityType::class, [
				'class' => Country::class,
				'label' => 'Pays',
				'choice_label' => 'name',
				'attr' => ['class' => 'form-control'],
			])
			->add('submit', SubmitType::class, [
				'attr' => ['class' => 'btn btn-primary my-3'],
			])
		;
	}

	public function configureOptions(OptionsResolver $resolver): void
	{
		$resolver->setDefaults([
			'data_class' => Publisher::class,
		]);
	}
}
