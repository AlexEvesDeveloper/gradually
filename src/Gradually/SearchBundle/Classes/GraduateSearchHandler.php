<?php

namespace Gradually\SearchBundle\Classes;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\Form\Form;

class GraduateSearchHandler
{
	protected $queryString;
	protected $queryParams = array();
	protected $doctrine;

	/**
     * Constructor.
     *
     * Initialise database connection and inject services.
	 *
	 * @param \Doctrine\Bundle\DoctrineBundle\Registry $doctrine.
     */
	public function __construct(Registry $doctrine)
	{
		$this->queryString = '
			SELECT graduate, qualification, university, degree FROM GraduallyUserBundle:GraduateUser graduate
	    	JOIN graduate.qualifications qualification
			JOIN qualification.university university
			JOIN qualification.degree degree
			JOIN qualification.result result
			WHERE graduate.isActive = :isActive
	    ';

	    $this->doctrine = $doctrine;
	}

	/**
	 * Construct the query string.
	 */
	public function prepareSearch(Form $form, array $orderBy)
	{
		$this->applyFilters($form);
		$this->queryString .= sprintf(' ORDER BY %s %s', $orderBy['property'], $orderBy['order']);
	}

	/**
	 * Execute the query.
	 *
	 * @return the result set.
	 */
	public function execute()
	{
		$query = $this->doctrine->getManager()->createQuery($this->queryString)->setParameters($this->queryParams);
		//$query->useResultCache(true, 600, 'KEY' . md5($this->getQueryString()));
		return $query->getResult();	
	}

	/**
	 * Returns the query string, with its parameters appended to the end, comma separated.
	 *
	 * Primarily used by memcache to create a unique key for each specificly filtered query,
	 * But also good for debugging purposes.
	 */
	public function getQueryString()
	{
		return $this->queryString . implode(',', $this->queryParams);
	}

	protected function applyFilters(Form $form)
	{
		// a hard coded filter, might need refactoring at some point
		$this->queryParams['isActive'] = true;

		if(($university = $form->getData()->getUniversity()) !== null){
			$this->queryString .= ' AND university.id = :university';
			$this->queryParams['university'] = $university->getId();
		}

		if(($degree = $form->getData()->getDegree()) !== null){
			$this->queryString .= ' AND degree.id = :degree';
			$this->queryParams['degree'] = $degree->getId();
		}

		if(($yearFrom = $form->getData()->getYearFrom()) === null){
			$yearFrom = date('Y') - 4;
		}
		
		if(($yearTo = $form->getData()->getYearTo()) === null){
			$yearTo = date('Y');
		}		

		$this->queryString .= ' AND (qualification.yearAttained >= :yearFrom 
								AND qualification.yearAttained <= :yearTo)';
		
		$this->queryParams['yearFrom'] = $yearFrom;
		$this->queryParams['yearTo'] = $yearTo;

		if(($resultFrom = $form->getData()->getResultFrom()) !== null){
			$resultFrom = $resultFrom->getId();
		}else{
			$resultFrom = 10;
		}	

		if(($resultTo = $form->getData()->getResultTo()) !== null){
			$resultTo = $resultTo->getId();
		}else{
			$resultTo = 6;
		}

		$this->queryString .= ' AND (result.id <= :resultFrom 
								AND result.id >= :resultTo)';
		
		$this->queryParams['resultFrom'] = $resultFrom;
		$this->queryParams['resultTo'] = $resultTo;		
	}
}
