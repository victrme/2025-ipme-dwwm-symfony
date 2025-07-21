<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class UserMeController extends AbstractController
{
	public function __invoke()
	{
		return $this->getUser();
	}
}
