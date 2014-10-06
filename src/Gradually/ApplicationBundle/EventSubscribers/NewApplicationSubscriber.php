<?php

namespace Gradually\ApplicationBundle\EventSubscribers;

use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Gradually\ApplicationBundle\Entity\Application;

class NewApplicationSubscriber implements EventSubscriber
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

		if($entity instanceof Application){
			// establish the recipents notification method
			$notificationMethod = $entity->getJob()->getRecruiter()->getNotificationMethod();

			$notifier = $this->container->get('gradually_notification.classes.notifiers.notifier');
			$notifier->notify(array(
				'event_name' => 'new_application',
				'notification_method' => $notificationMethod,
				'application' => $entity
			));
		}	
	}
}
