<?php

namespace Gradually\NotificationBundle\Classes\Notifiers;

use Gradually\NotificationBundle\Classes\Notifiers\NotifierInterface;

class Notifier implements NotifierInterface
{
	static $instance;

	public static function getInstance()
	{
		static $instance = null;

		if($instance === null){
			$instance = new static();
		}

		return $instance;
	}

	// based on the info in the $data array, it will call the correct notification event 
	// based on the user's notification method
	public function notify(array $data)
	{
		$notifierClassName = sprintf('Gradually\NotificationBundle\Classes\Notifiers\%1$s\%1$s%2$sNotifier',
			ucfirst($data['notification_method']),
			$data['event_name']
		);

		$notifierClass = $notifierClassName::getInstance();
		$notifierClass->notify($data);
	}

	// insist it remains a singleton
	private function __construct(){}
	private function __clone(){}
	private function __wakeup(){}
}