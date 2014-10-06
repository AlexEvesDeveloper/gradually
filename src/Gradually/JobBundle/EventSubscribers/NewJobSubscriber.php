<?php

namespace Gradually\JobBundle\EventSubscribers;

use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Gradually\JobBundle\Entity\Job;

class NewJobSubscriber implements EventSubscriber
{
	private $container;

	public function __construct(ContainerInterface $container)
	{
		$this->container = $container;
	}

	public function getSubscribedEvents()
	{
		return array('postPersist');
	}

	public function postPersist(LifecycleEventArgs $args)
	{
		$em = $args->getEntityManager();
		$entity = $args->getEntity();

		if($entity instanceof Job){
			$this->handleNotifications($entity, $em);
		}	
	}

	private function handleNotifications(Job $entity, EntityManager $em)
	{
		// get the Graduates subscribed to this Recruiter
		$recruiter = $entity->getRecruiter();
		$subscribers = $em->getRepository('GraduallyUserBundle:RecruiterUser')
			->findAllSubscribedGraduates($recruiter->getId());
		// notify each Graduate, using their preferred method of communication
		foreach($subscribers as $subscriber){
			$notificationMethod = $subscriber->getNotificationMethod();
			$notifier = $this->container->get('gradually_notification.classes.notifiers.notifier');
			$notifier->notify(array(
				'event_name' => 'new_job',
				'notification_method' => $notificationMethod,
				'job' => $entity,
				'graduate' => $subscriber
			));
		}
	} 
}
