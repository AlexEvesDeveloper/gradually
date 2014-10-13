<?php

namespace Gradually\SearchBundle\Classes;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\Form;

class RecruiterSearchHandler extends BaseSearchHandler
{
	/**
	 * Create the opening query string that will be applicable in all search cases
     */
	public function initQueryString()
	{
		$this->queryString = '
			SELECT recruiter FROM GraduallyUtilBundle:RecruiterUser recruiter
			WHERE recruiter.isActive = :isActive
	    ';
	}

	protected function applyFilters(Form $form)
	{
		$this->queryParams['isActive'] = true;

		if(($recruiter = $form->getData()->getRecruiter()) !== null){
			$this->queryString = sprintf('%s AND recruiter.id = :recruiter', $this->queryString);
			$this->queryParams['recruiter'] = $recruiter->getId();
		}	
	}
}