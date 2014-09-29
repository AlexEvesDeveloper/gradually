<?php

namespace Gradually\ApplicationBundle\EventListeners;

use Doctrine\ORM\Event\PreFlushEventArgs;
use Gradually\ApplicationBundle\Entity\Application;
use Gradually\NotificationBundle\Classes\Notifiers\Notifier;

class ApplicationListener 
{
	public function preFlush(Application $application, PreFlushEventArgs $args)
	{
		$em = $args->getEntityManager();

		// notify the recruiter of the application
		$this->notifyRecruiter($application, $em);

		// attach the Graduate to the Recruiter so that the Recruiter can now access the Graduate
		$graduate = $application->getGraduate();
		$graduate->addRecruiter($application->getJob()->getRecruiter());
		$em->persist($graduate);
	}

	private function notifyRecruiter($application, $em)
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
}