<?php

namespace Gradually\SearchBundle\Classes;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\Form\Form;
use Gradually\SearchBundle\Form\JobSearchType;
use Gradually\LibraryBundle\Classes\Doctrine\Point;

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
			JOIN job.location location
			WHERE job.isActive = :isActive
	    ';

	    $this->doctrine = $doctrine;
	}

	/**
	 * Construct the query string.	
  	 */
	public function prepareSearch(Form $form, array $orderBy)
	{
		$this->applyFilters($form);
		$this->queryString = sprintf('%s ORDER BY %s %s', $this->queryString, $orderBy['property'], $orderBy['order']);
	}
	
	/**
	 * Execute the query.
	 *
	 * @return Result set.
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

		if(($recruiter = $form->getData()->getRecruiter()) !== null){
			$this->queryString = sprintf('%s AND recruiter.id = :recruiter', $this->queryString);
			$this->queryParams['recruiter'] = $recruiter->getId();
		}

		if(($salaryFrom = $form->getData()->getSalaryFrom()) !== null){

			$this->queryString = sprintf('%s AND ((job.salaryFrom >= :salaryFrom', $this->queryString);
			
			if(($salaryTo = $form->getData()->getSalaryTo()) !== null){
				$this->queryString = sprintf('%s AND job.salaryFrom <= :salaryTo) OR (job.salaryTo >= :salaryFrom AND job.salaryTo <= :salaryTo))', $this->queryString);
				$this->queryParams['salaryTo'] = $salaryTo;
			}else{
				$this->queryString = sprintf('%s OR job.salaryTo >= :salaryFrom))', $this->queryString);
			}
			$this->queryParams['salaryFrom'] = $salaryFrom;
		}	

		if(($locationString = $form->getData()->getLocationString()) !== null){
			if(is_numeric($locationString[1]) || is_numeric($locationString[2])){
				// postcode entered
				$locations = $this->doctrine->getRepository('GraduallyJobBundle:Location')->findOneByPostcode($locationString);
			}else{
				// town entered, need all postcodes for this town
				$locations = $this->doctrine->getRepository('GraduallyJobBundle:Location')->findByTown(ucwords($locationString));
			}
			
			if(($distance = $form->getData()->getDistance()) === null){
				$distance = 5;
			}

			// for now, only filter by location if we find a Location entity
			if(($locationCount = count($locations)) == true){
				if($locationCount == 1){
					$point = $locations->getPoint();
				}else{
					$point = $locations[0]->getPoint();
				}

				$this->queryString = sprintf('%s AND (DISTANCE(location.point, POINT_STR(:point)) / 1600 < :distance', $this->queryString);
				$this->queryParams['point'] = $point;

				// now handle extra locations that will be here if a town was entered
				for($i = 1; $i < $locationCount; $i++){
					$pointStr = sprintf('point%d', $i);
					$this->queryString = sprintf('%s OR DISTANCE(location.point, POINT_STR(:%s)) / 1600 < :distance', $this->queryString, $pointStr);
					$this->queryParams[$pointStr] = $locations[$i]->getPoint();
				}
				$this->queryString = sprintf('%s)', $this->queryString);

				$this->queryParams['distance'] = $distance;
			}
		}
	}
}
