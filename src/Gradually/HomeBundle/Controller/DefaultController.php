<?php

namespace Gradually\HomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     * @Template("::base.html.twig")
     */
    public function indexAction()
    {
        $imagePath = 'uploads/profile_images/default/female.jpg';

	    $userType = ($user = $this->getUser()) !== null ? $user->getType() : "ANONYMOUS";


	    if($user && $user->getImage()){
            $imagePath = $user->getImage()->getFullPath();
	    }	

        return array(
            'userType' => $userType,
            'imagePath' => $imagePath
        );
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
