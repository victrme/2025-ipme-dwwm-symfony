<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options): void
	{
		$builder
			->add('nickname', null, [
				"label" => "Surnom",
				"attr" => ["class" => "form-control"]
			])
			->add('name', null, [
				"label" => "Nom",
				"attr" => ["class" => "form-control"]
			])
			->add('email', EmailType::class, [
				"label" => "Adresse mail",
				"attr" => ["class" => "form-control"]
			])
			->add('password', RepeatedType::class, [
				"type" => PasswordType::class,
				"first_options" => [
					"label" => "Mot de passe",
					"attr" => ["class" => "form-control"]
				],
				"second_options" => [
					"label" => "Confirmez le mot de passe",
					"attr" => ["class" => "form-control"]
				]
			])
			->add('save', SubmitType::class, [
				"label" => "Inscrivez-vous",
				"attr" => ["class" => "btn btn-primary"]
			]);
			// ->add('createdAt', null, [
			//     'widget' => 'single_text',
			// ])
			// ->add('country', EntityType::class, [
			//     'class' => Country::class,
			//     'choice_label' => 'id',
			// ])
			// ->add('wantedGames', EntityType::class, [
			//     'class' => Game::class,
			//     'choice_label' => 'id',
			//     'multiple' => true,
			// ])
		;
	}

	public function configureOptions(OptionsResolver $resolver): void
	{
		$resolver->setDefaults([
			'data_class' => User::class
		]);
	}
}
