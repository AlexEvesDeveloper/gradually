<?php

namespace Gradually\UtilBundle\Repository;

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

	public function findMostRecentJobs($recruiterId, $max)
	{
		$query = "
			SELECT job FROM GraduallyUtilBundle:Job job
			JOIN job.recruiter recruiter
			WHERE recruiter.id = :recruiterId
			ORDER BY job.id DESC
		";

		$params['recruiterId'] = $recruiterId;

		return $this->getEntityManager()->createQuery($query)->setParameters($params)->setMaxResults($max)->getResult();
	}

	public function findMostViewedJobs($recruiterId, $max)
	{
		$query = "
			SELECT job FROM GraduallyUtilBundle:Job job
			JOIN job.recruiter recruiter
			WHERE recruiter.id = :recruiterId
			ORDER BY job.viewCount DESC
		";

		$params['recruiterId'] = $recruiterId;

		return $this->getEntityManager()->createQuery($query)->setParameters($params)->setMaxResults($max)->getResult();
	}

	public function findMostAppliedJobs($recruiterId, $max)
	{
		$query = "
			SELECT job FROM GraduallyUtilBundle:Job job
			JOIN job.recruiter recruiter
			WHERE recruiter.id = :recruiterId
			ORDER BY job.applicationCount DESC
		";

		$params['recruiterId'] = $recruiterId;

		return $this->getEntityManager()->createQuery($query)->setParameters($params)->setMaxResults($max)->getResult();
	}
}