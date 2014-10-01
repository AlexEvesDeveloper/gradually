<?php

namespace Gradually\NotificationBundle\Classes\Notifiers\Email;

use JMS\DiExtraBundle\Annotation as DI;
use Gradually\NotificationBundle\Classes\Notifiers\NotifierInterface;

class EmailNewApplicationNotifier implements NotifierInterface
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

	// pass the mailer object in here?
	public function notify(array $data)
	{
		$application = $data['application'];

		$content = sprintf('Hi %s, %s has applied to your job, titled: %s.<br>The following cover note was attached:<br>%s', 
			$application->getJob()->getRecruiter()->getCompanyName(),
			$application->getGraduate()->getFirstName(), 
			$application->getJob()->getTitle(),
			$application->getCoverNote()
		);

		$message = \Swift_Message::newInstance()
			->setSubject(sprintf('Application received: %s', $application->getJob()->getTitle()))
			->setFrom('noreply@gradually.alexeves.co.uk')
			->setTo($application->getJob()->getRecruiter()->getEmail())
			->setBody($content);

		print $application->getJob()->getRecruiter()->getEmail();
		exit;
	}

	private function __construct(){
	private function __clone(){}
	private function __wakeup(){}
}
