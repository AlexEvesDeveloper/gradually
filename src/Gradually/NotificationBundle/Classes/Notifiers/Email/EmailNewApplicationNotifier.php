<?php

namespace Gradually\NotificationBundle\Classes\Notifiers\Email;

use Gradually\NotificationBundle\Classes\Notifiers\NotifierInterface;

class EmailNewApplicationNotifier implements NotifierInterface
{
	private $mailer;

	public function __construct(\Swift_Mailer $mailer)
	{
		$this->mailer = $mailer;
	}

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

		$this->mailer->send($message);
	}

}
