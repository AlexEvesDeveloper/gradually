<?php

namespace Gradually\SearchBundle\Classes;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\Form\Form;
use Gradually\SearchBundle\Form\JobSearchType;

class JobSearchHandler
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
			SELECT job, recruiter FROM GraduallyJobBundle:Job job
			JOIN job.recruiter recruiter
			WHERE job.isActive = :isActive
	    ';

	    $this->doctrine = $doctrine;
	}

	public function handleSearch(Form $form, array $orderBy)
	{
		$this->applyFilters($form);

		$this->queryString .= sprintf(' ORDER BY %s %s', $orderBy['property'], $orderBy['order']);

	    $query = $this->doctrine->getManager()->createQuery($this->queryString)->setParameters($this->queryParams);

	    return $query->getResult();
	}

	protected function applyFilters(Form $form)
	{
		// a hard coded filter, might need refactoring at some point
		$this->queryParams['isActive'] = true;

		if(($recruiter = $form->getData()->getRecruiter()) !== null){
			$this->queryString .= sprintf(' AND recruiter.id = :recruiter');
			$this->queryParams['recruiter'] = $recruiter->getId();
		}

		if(($salaryFrom = $form->getData()->getSalaryFrom()) !== null){

			$this->queryString .= sprintf(' AND (job.salaryFrom >= :salaryFrom');
			
			if(($salaryTo = $form->getData()->getSalaryTo()) !== null){
				$this->queryString .= sprintf(' AND job.salaryFrom <= :salaryTo OR job.salaryTo >= :salaryFrom AND job.salaryTo <= :salaryTo)');
				$this->queryParams['salaryTo'] = $salaryTo;
			}else{
				$this->queryString .= sprintf(' OR job.salaryTo >= :salaryFrom)');
			}
			$this->queryParams['salaryFrom'] = $salaryFrom;
		}		
	}
}