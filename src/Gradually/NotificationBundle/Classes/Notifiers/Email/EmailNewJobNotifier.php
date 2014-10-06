<?php

namespace Gradually\NotificationBundle\Classes\Notifiers\Email;

use Gradually\NotificationBundle\Classes\Notifiers\NotifierInterface;

class EmailNewJobNotifier implements NotifierInterface
{
        private $mailer;

        public function __construct(\Swift_Mailer $mailer)
        {
                $this->mailer = $mailer;
        }

	public function notify(array $data)
	{
		$job = $data['job'];
		$graduate = $data['graduate'];
		$recruiter = $job->getRecruiter();

		$content = sprintf('Hi %s, %s have posted a new job: %s', 
			$graduate->getFirstName(), 
			$recruiter->getCompanyName(),
			$job->getTitle()
		);

                $message = \Swift_Message::newInstance()
                        ->setSubject(sprintf('New job alert: %s', $job->getTitle()))
                        ->setFrom('noreply@gradually.alexeves.co.uk')
                        ->setTo($graduate->getEmail())
                        ->setBody($content);

	
                $this->mailer->send($message);
	}
}
