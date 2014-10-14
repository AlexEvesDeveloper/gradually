<?php

namespace Gradually\SearchBundle\Classes;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\Form\Form;
use Gradually\UtilBundle\Form\JobSearchType;
use Gradually\UtilBundle\Classes\Doctrine\Point;

class JobSearchHandler extends BaseSearchHandler
{
	/**
	 * Create the opening query string that will be applicable in all search cases
     */
	public function initQueryString()
	{
		$this->queryString = '
			SELECT job, recruiter FROM GraduallyUtilBundle:Job job
			JOIN job.recruiter recruiter
			JOIN job.location location
			WHERE job.isActive = :isActive
	    ';
	}

	protected function applyFilters(Form $form)
	{
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
				$locations = $this->em->getRepository('GraduallyUtilBundle:Location')->findOneByPostcode($locationString);
			}else{
				// town entered, need all postcodes for this town
				$locations = $this->em->getRepository('GraduallyUtilBundle:Location')->findByTown(ucwords($locationString));
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
