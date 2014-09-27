<?php

namespace Gradually\JobBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Form;
use Gradually\SearchBundle\Classes\JobSearchHandler;

/**
 * JobRepository
 */
class JobRepository extends EntityRepository
{
	public function search(Form $form, array $orderBy = array('property' => 'job.id', 'order' => 'ASC'))
	{
		$sh = new JobSearchHandler($this->getEntityManager());

		$sh->prepareQuery($form, $orderBy);		
		
		$query = $this->getEntityManager()->createQuery($sh->getQueryString())->setParameters($sh->getQueryParameters());
		$query->useResultCache(true, 600, 'KEY' . md5($sh->getEncodedQueryString()));
		
		return $query->getResult();	
	}
}