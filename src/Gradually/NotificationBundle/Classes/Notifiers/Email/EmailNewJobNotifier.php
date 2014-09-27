<?php

namespace Gradually\NotificationBundle\Classes\Notifiers\Email;

use Gradually\NotificationBundle\Classes\Notifiers\NotifierInterface;

class EmailNewJobNotifier implements NotifierInterface
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

	public function notify(array $data)
	{
		$graduate = $data['graduate'];
		$recruiter = $data['recruiter'];
		$job = $data['job'];

		$content = sprintf('Hi %s, %s have posted a new job: %s', 
			$graduate->getFirstName(), 
			$recruiter->getCompanyName(),
			$job->getTitle()
		);
	}

	// insist it remains a singleton
	private function __construct(){}
	private function __clone(){}
	private function __wakeup(){}
}