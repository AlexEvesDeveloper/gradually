<?php

namespace Gradually\JobBundle\EventSubscribers;

use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Gradually\JobBundle\Entity\Job;
use Gradually\NotificationBundle\Classes\Notifiers\Notifier;

class NewJobSubscriber implements EventSubscriber
{
	public function getSubscribedEvents()
	{
		return array('postPersist');
	}

	public function postPersist(LifecycleEventArgs $args)
	{
		$entity = $args->getEntity();
		$em = $args->getEntityManager();

		if($entity instanceof Job){
			$this->handleNotifications($entity, $em);
		}
	}

	private function handleNotifications($entity, $em)
	{
		// get the Graduates subscribed to this Recruiter
		$recruiter = $entity->getRecruiter();
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
				'job' => $entity,
				'graduate' => $subscriber
			));
		}	
	}
}