<?php

namespace Gradually\UserBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Form;
use Gradually\SearchBundle\Classes\RecruiterSearchHandler;

/**
 * RecruiterUserRepository
 */
class RecruiterUserRepository extends EntityRepository
{
	public function findAllSubscribedGraduates($recruiterId)
	{
		$query = "
			SELECT graduate FROM GraduallyUserBundle:GraduateUser graduate
			JOIN graduate.recruiters recruiter
			WHERE recruiter.id = :recruiterId
		";

		$params['recruiterId'] = $recruiterId;

		return $this->getEntityManager()->createQuery($query)->setParameters($params)->getResult();
	}

	public function findRecentJobs($recruiterId, $max)
	{
		$query = "
			SELECT job FROM GraduallyJobBundle:Job job
			JOIN job.recruiter recruiter
			WHERE recruiter.id = :recruiterId
			AND job.isActive = :isActive
			ORDER BY job.id DESC
		";

		$params['recruiterId'] = $recruiterId;
		$params['isActive'] = true;

		return $this->getEntityManager()->createQuery($query)->setParameters($params)->setMaxResults($max)->getResult();
	}

	public function findRecentApplications($recruiterId, $max)
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

	public function search(Form $form, array $orderBy = array('property' => 'recruiter.id', 'order' => 'ASC'))
	{
		$sh = new RecruiterSearchHandler($this->getEntityManager());

		$sh->prepareQuery($form, $orderBy);		
		
		$query = $this->getEntityManager()->createQuery($sh->getQueryString())->setParameters($sh->getQueryParameters());
		$query->useResultCache(true, 600, 'KEY' . md5($sh->getEncodedQueryString()));
		
		return $query->getResult();	
	}
}
