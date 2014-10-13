<?php

namespace Gradually\UtilBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Form;
use Gradually\SearchBundle\Classes\GraduateSearchHandler;

/**
 * GraduateUserRepository
 */
class GraduateUserRepository extends EntityRepository
{
	public function search(Form $form, array $orderBy = array('property' => 'graduate.id', 'order' => 'ASC'))
	{
		$sh = new GraduateSearchHandler($this->getEntityManager());

		$sh->prepareQuery($form, $orderBy);		
		
		$query = $this->getEntityManager()->createQuery($sh->getQueryString())->setParameters($sh->getQueryParameters());
		$query->useResultCache(true, 600, 'KEY' . md5($sh->getEncodedQueryString()));
		
		return $query->getResult();	
	}
}
