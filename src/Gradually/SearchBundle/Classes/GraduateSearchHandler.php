<?php

namespace Gradually\SearchBundle\Classes;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\Form\Form;
use Gradually\SearchBundle\Form\GraduateSearchType;

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
		$query->useResultCache(true, 600, 'KEY' . md5($this->getQueryString()));
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
		foreach(GraduateSearchType::getFields() as $field){
			$getMethod = sprintf('get%s', ucfirst($field['field']));
	    
	    	if(($formFieldValue = $form->getData()->{$getMethod}()) === null){
	    		// field was left blank, so no filter to apply on this field
	    		continue;
	    	}
	   			
	   		$this->queryString .= sprintf(' AND %s.%s = :%s', 
	   			$field['owningEntity'], 
	   			$field['property'], 
	   			$field['field']
	   		);
	   		
			$this->queryParams[$field['field']] = $field['isEntity'] ? 
				$formFieldValue->getId() :
				$formFieldValue; 
		}		
	}
}
