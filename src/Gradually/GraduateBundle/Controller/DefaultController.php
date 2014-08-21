<?php

namespace Gradually\GraduateBundle\Controller;

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
    	$graduates = $this->getDoctrine()->getManager()->getRepository('GraduallyUserBundle:GraduateUser')->findAll();

        return array('graduates' => $graduates);
    }

    /**
     * @Route("/{id}")
     * @Template()
     */
    public function viewAction($id)
    {
    	// does the user have access to this profile?
    	if((!$this->get('security.context')->isGranted('ROLE_ADMIN')) && ($this->getUser()->getId() != $id)){
            throw $this->createAccessDeniedException('Unable to access this page!');
        }

    	$graduate = $this->getDoctrine()->getManager()->getRepository('GraduallyUserBundle:GraduateUser')->find($id);

        return array('graduate' => $graduate);
    }
}
