<?php

namespace Gradually\JobBundle\EventListeners;

use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Gradually\JobBundle\Entity\Job;
use Gradually\NotificationBundle\Classes\Notifiers\Notifier;

class JobListener 
{
	public function postPersist(Job $job, LifecycleEventArgs $args)
	{
		$em = $args->getEntityManager();

		$this->NotifySubscribedGraduates($job, $em);
	}

	private function NotifySubscribedGraduates($job, $em)
	{
		// get the Graduates subscribed to this Recruiter
		$recruiter = $job->getRecruiter();
		$subscribers = $em->getRepository('GraduallyUserBundle:RecruiterUser')
			->findAllSubscribedGraduates($recruiter->getId());	

		// notify each Graduate, using their preferred method of communication
		foreach($subscribers as $subscriber){
			$notificationMethod = $subscriber->getNotificationMethod();
			$notifier = Notifier::getInstance();
			$notifier->notify(array(
				'event_name' => 'NewJob',
				'notification_method' => $notificationMethod,
				'recruiter' => $recruiter,
				'job' => $job,
				'graduate' => $subscriber
			));
		}	
	}
}