<?php

namespace Gradually\ApplicationBundle\EventListeners;

use Doctrine\ORM\Event\PreFlushEventArgs;
use Doctrine\ORM\EntityManager;
use Gradually\UserBundle\Entity\RecruiterUser;
use Gradually\UserBundle\Entity\GraduateUser;
use Gradually\ApplicationBundle\Entity\Application;
use Gradually\NotificationBundle\Classes\Notifiers\Notifier;

class ApplicationListener 
{
	public function preFlush(Application $application, PreFlushEventArgs $args)
	{
		$em = $args->getEntityManager();

		// notify the recruiter of the application
		$this->notifyRecruiter($application);

		// attach the Graduate to the Recruiter so that the Recruiter can now access the Graduate
		$this->connectRecruiterWithGraduate($application->getJob()->getRecruiter(), $application->getGraduate(), $em);

	}

	private function notifyRecruiter(Application $application)
	{
		// establish the Recruiter, and their notification method
		$recruiter = $application->getJob()->getRecruiter();
		$notificationMethod = $recruiter->getNotificationMethod();

		$notifier = Notifier::getInstance();
		$notifier->notify(array(
			'event_name' => 'NewApplication',
			'notification_method' => $notificationMethod,
			'application' => $application
		));
	}

	private function connectRecruiterWithGraduate(RecruiterUser $recruiter, GraduateUser $graduate, EntityManager $em)
	{
		// if already connected, don't attempt to reconnect, as there will be a unique key violation
		foreach($graduate->getRecruiters() as $r){
			if($r->getId() == $recruiter->getId()){
				// already connected
				return;
			}
		}

		// not connected, so connect them
		$graduate = $application->getGraduate();
		$graduate->addRecruiter($application->getJob()->getRecruiter());
		$em->persist($graduate);		
	}
}