<?php

namespace Gradually\NotificationBundle\Classes\Notifiers;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Gradually\NotificationBundle\Classes\Notifiers\NotifierInterface;

class Notifier implements NotifierInterface
{
        private $container;

        public function __construct(ContainerInterface $container)
        {
                $this->container = $container;
        }
	// based on the info in the $data array, it will call the correct notification event 
	// based on the user's notification method
	public function notify(array $data)
	{
		$notifierServiceName = sprintf('gradually_notification.classes.notifiers.%1$s.%1$s_%2$s_notifier',
			$data['notification_method'],
			$data['event_name']
		);

		$concreteNotifier = $this->container->get($notifierServiceName);
		$concreteNotifier->notify($data);
	}

}
