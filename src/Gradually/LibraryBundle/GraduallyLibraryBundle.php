<?php

namespace Gradually\LibraryBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

use Doctrine\ORM\EntityManager;
use Doctrine\DBAL\Types\Type;

class GraduallyLibraryBundle extends Bundle
{
	public function boot()
	{
		// Instantiate a new DBAL data type
		//Type::addType('point', 'Gradually\LibraryBundle\Classes\Doctrine\PointType');
	
		//$em = $this->container->get('doctrine.orm.default_entity_manager');
		//$conn = $em->getConnection()->getDatabasePlatform()->registerDoctrineTypeMapping('PointType', 'point');
	}
}
