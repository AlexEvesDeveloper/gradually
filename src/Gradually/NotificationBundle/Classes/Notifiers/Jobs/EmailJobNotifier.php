<?php

namespace Gradually\NotificationBundle\Classes\Notifiers\Jobs;

use Gradually\NotificationBundle\Classes\Notifiers\NotifierInterface;

class EmailJobNotifier implements NotifierInterface
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

	public function notify(array $data = array())
	{
		print 'Emailing a job';
	}

	private function __construct(){}
	private function __clone(){}
	private function __wakeup(){}
}