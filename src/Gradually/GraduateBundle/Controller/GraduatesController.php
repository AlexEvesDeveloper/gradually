<?php

namespace Gradually\GraduateBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/graduates")
 */
class GraduatesController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
    	$graduates = $this->getDoctrine()->getManager()->getRepository('GraduallyUserBundle:GraduateUser')->findAll();

        return array('graduates' => $graduates);
    }
}
