<?php

namespace Gradually\NotificationBundle\Classes\Notifiers;

interface NotifierInterface
{
	public function notify(array $data);
}