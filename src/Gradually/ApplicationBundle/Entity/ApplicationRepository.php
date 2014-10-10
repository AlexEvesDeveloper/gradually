<?php

namespace Gradually\ApplicationBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Form;

/**
 * ApplicationRepository
 */
class ApplicationRepository extends EntityRepository
{
	public function findApplicationCountForARecruiter($recruiterId)
	{
		$query = "
			SELECT COUNT(application.id) FROM GraduallyApplicationBundle:Application application
			JOIN application.job job
			JOIN job.recruiter recruiter
			WHERE recruiter.id = :recruiterId
		";

		$params['recruiterId'] = $recruiterId;

		return $this->getEntityManager()->createQuery($query)->setParameters($params)->getResult();		
	}

	public function findMostRecentApplications($recruiterId, $max)
	{
		$query = "
			SELECT application FROM GraduallyApplicationBundle:Application application
			JOIN application.job job
			JOIN job.recruiter recruiter
			WHERE recruiter.id = :recruiterId
			ORDER BY application.id DESC
		";

		$params['recruiterId'] = $recruiterId;

		return $this->getEntityManager()->createQuery($query)->setParameters($params)->setMaxResults($max)->getResult();
	}
}