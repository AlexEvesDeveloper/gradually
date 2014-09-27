<?php

namespace Gradually\UserBundle\Entity;

use Doctrine\ORM\EntityRepository;

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
}
