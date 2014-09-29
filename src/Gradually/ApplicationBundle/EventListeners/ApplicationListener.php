<?php

namespace Gradually\ApplicationBundle\EventListeners;

use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Gradually\ApplicationBundle\Entity\Application;
use Gradually\NotificationBundle\Classes\Notifiers\Notifier;

class ApplicationListener 
{
	public function postPersist(Application $application, LifecycleEventArgs $args)
	{
		$em = $args->getEntityManager();

		$this->notifyRecruiter($application, $em);
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