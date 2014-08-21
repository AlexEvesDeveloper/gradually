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
        // redirect to login if not logged in
        if(($user = $this->getUser()) == null){
            return $this->redirect($this->generateUrl('gradually_user_default_login'));
        }
    	// access denied if user is not admin, does not own this profile, OR IS NOT LINKED WITH THIS PROFILE
    	if((!$this->get('security.context')->isGranted('ROLE_ADMIN')) && ($user->getId() != $id)){
            throw $this->createAccessDeniedException('Unable to access this page!');
        }

    	$graduate = $this->getDoctrine()->getManager()->getRepository('GraduallyUserBundle:GraduateUser')->find($id);

        return array('graduate' => $graduate);
    }
}
