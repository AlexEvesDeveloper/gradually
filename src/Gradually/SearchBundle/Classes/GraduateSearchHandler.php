<?php

namespace Gradually\SearchBundle\Classes;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\Form;

class GraduateSearchHandler extends BaseSearchHandler
{
	/**
	 * Create the opening query string that will be applicable in all search cases
     */
	public function initQueryString()
	{
		$this->queryString = '
			SELECT graduate, qualification, university, degree FROM GraduallyUserBundle:GraduateUser graduate
	    	JOIN graduate.qualifications qualification
			JOIN qualification.university university
			JOIN qualification.degree degree
			JOIN qualification.result result
			WHERE graduate.isActive = :isActive
	    ';
	}

	protected function applyFilters(Form $form)
	{
		$this->queryParams['isActive'] = true;

		if(($university = $form->getData()->getUniversity()) !== null){
			$this->queryString = sprintf('%s AND university.id = :university', $this->queryString);
			$this->queryParams['university'] = $university->getId();
		}

		if(($degree = $form->getData()->getDegree()) !== null){
			$this->queryString = sprintf('%s AND degree.id = :degree', $this->queryString);
			$this->queryParams['degree'] = $degree->getId();
		}

		if(($yearFrom = $form->getData()->getYearFrom()) === null){
			$yearFrom = date('Y') - 4;
		}
		
		if(($yearTo = $form->getData()->getYearTo()) === null){
			$yearTo = date('Y');
		}		

		$this->queryString = sprintf('%s AND (qualification.yearAttained >= :yearFrom 
								AND qualification.yearAttained <= :yearTo)', $this->queryString);
		
		$this->queryParams['yearFrom'] = $yearFrom;
		$this->queryParams['yearTo'] = $yearTo;

		if(($resultFrom = $form->getData()->getResultFrom()) !== null){
			$resultFrom = $resultFrom->getId();
		}else{
			$result = $this->em->getRepository('GraduallyUtilBundle:DegreeResult')->findOneByName('Ordinary');
			$resultFrom = $result->getId();
		}	

		if(($resultTo = $form->getData()->getResultTo()) !== null){
			$resultTo = $resultTo->getId();
		}else{
			$result = $this->em->getRepository('GraduallyUtilBundle:DegreeResult')->findOneByName('First-class honours');
			$resultTo = $result->getId();
		}

		$this->queryString = sprintf('%s AND (result.id <= :resultFrom 
								AND result.id >= :resultTo)', $this->queryString);
		
		$this->queryParams['resultFrom'] = $resultFrom;
		$this->queryParams['resultTo'] = $resultTo;		
	}
}
