<?php

namespace Gradually\RecruiterBundle\Controller;

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
    	$recruiters = $this->getDoctrine()->getManager()->getRepository('GraduallyUserBundle:RecruiterUser')->findAll();

        return array('recruiters' => $recruiters);
    }

    /**
     * @Route("/{id}")
     * @Template()
     */
    public function viewAction($id)
    {
    	$recruiter = $this->getDoctrine()->getManager()->getRepository('GraduallyUserBundle:RecruiterUser')->find($id);

        return array('recruiter' => $recruiter);
    }
}
