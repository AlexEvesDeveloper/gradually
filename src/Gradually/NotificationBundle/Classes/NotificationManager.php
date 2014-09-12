<?php

namespace Gradually\NotificationBundle\Classes;

use  Gradually\NotificationBundle\Classes\Notifiers\NotifierInterface;

class NotificationManager
{
	protected $notifier;

	public function __construct(NotifierInterface $notifier)
	{
		$this->notifier = $notifier;
	}

	public function setNotifier(NotifierInterface $notifier)
	{
		$this->notifier = $notifer;
	}

	public function notify(array $data = array())
	{
		$this->notifier->notify($data);
	}
}