<?php

namespace Gradually\NotificationBundle\Classes\Factories;

use Gradually\NotificationBundle\Classes\Notifiers\Jobs\EmailJobNotifier;
use Gradually\NotificationBundle\Classes\Notifiers\Jobs\TextJobNotifier;

class JobNotifierFactory
{
	public static function getNotifier($method)
	{
		switch($method)
		{
			case 'email':
				return EmailJobNotifier::getInstance();
				break;
			case 'text':
				return TextJobNotifier::getInstance();
				break;
		}
	}
}