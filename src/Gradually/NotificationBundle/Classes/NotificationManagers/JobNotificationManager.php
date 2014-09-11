<?php

namespace Gradually\NotificationBundle\Classes\NotificationManagers;

use Gradually\NotificationBundle\Classes\Notifiers\Jobs\BaseJobNotifier;

class JobNotificationManager extends BaseNotificationManager
{
	protected function setNotifierType(BaseJobNotifier $type)
	{
		$this->notifierType = $type;
	}
}