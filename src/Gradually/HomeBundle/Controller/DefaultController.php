<?php

namespace Gradually\HomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        return array(
        	'userType' => ($user = $this->getUser()) !== null ? $user->getType() : null
        );
    }

    /**
     * @Template()
     */
    public function anonymousSidebarAction()
    {
    	return array();
    }

    /**
     * @Template()
     */
    public function recruiterSidebarAction()
    {
    	return array(
    		'recruiter' => $this->getUser()
    	);
    }

    /**
     * @Template()
     */
    public function graduateSidebarAction()
    {
    	return array();
    }

    /**
     * @Template()
     */
    public function recruiterTopbarAction()
    {
        return array(
            'recruiter' => $this->getUser()
        );
    }

    /**
     * @Template()
     */
    public function inboxPopupAction()
    {
        return array(
            'user' => $this->getUser()
        );
    }
}