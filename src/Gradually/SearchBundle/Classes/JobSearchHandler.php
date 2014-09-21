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
		$this->queryString .= sprintf(' ORDER BY %s %s', $orderBy['property'], $orderBy['order']);
	}
	
	/**
	 * Execute the query.
	 *
	 * @return Result set.
	 */
	public function execute()
	{
		//$query = $this->doctrine->getManager()->createQuery('SELECT job FROM GraduallyJobBundle:Job job JOIN job.location location WHERE DISTANCE(location.point, POINT_STR(:point)) < 5');
		//$point = new Point(10, 20.5);
		//$query->setParameter('point', $point);
		//MAYBE NOT NEEDED $query->execute();
		//$query = $this->doctrine->getManager()->createQuery($this->queryString)->setParameters($this->queryParams);
		
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
			$this->queryString .= ' AND recruiter.id = :recruiter';
			$this->queryParams['recruiter'] = $recruiter->getId();
		}

		if(($salaryFrom = $form->getData()->getSalaryFrom()) !== null){

			$this->queryString .= ' AND (job.salaryFrom >= :salaryFrom';
			
			if(($salaryTo = $form->getData()->getSalaryTo()) !== null){
				$this->queryString .= ' AND job.salaryFrom <= :salaryTo OR job.salaryTo >= :salaryFrom AND job.salaryTo <= :salaryTo)';
				$this->queryParams['salaryTo'] = $salaryTo;
			}else{
				$this->queryString .= ' OR job.salaryTo >= :salaryFrom)';
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

				$this->queryString .= ' AND DISTANCE(location.point, POINT_STR(:point)) / 1600 < :distance';
				$this->queryParams['point'] = $point;

				// now handle extra locations that will be here if a town was entered
				for($i = 1; $i < $locationCount; $i++){
					$pointStr = sprintf('point%d', $i);
					$this->queryString .= sprintf(' OR DISTANCE(location.point, POINT_STR(:%s)) / 1600 < :distance', $pointStr);
					$this->queryParams[$pointStr] = $locations[$i]->getPoint();
				}


				$this->queryParams['distance'] = $distance;
			}
		}
	}
}
