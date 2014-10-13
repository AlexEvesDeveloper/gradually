<?php

namespace Gradually\ApplicationBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Gradually\UtilBundle\Entity\GraduateUser;

/**
 * @Route("/graduates/{id}/applications")
 */
class GraduateApplicationManagerController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction($id)
    {
        if(!$this->authenticate($id)){
            return $this->redirect($this->generateUrl('gradually_user_default_login'));
        }

        $graduate = $this->getDoctrine()->getManager()->getRepository('GraduallyUtilBundle:GraduateUser')->find($id);
        
        return array(
            'graduate' => $graduate,
            'applications' => $graduate->getApplications(),
        );
    }

    /**
     * Authenticate the current User as to whether they can access the requested resource
     *
     * @param $id ID of profile to whom the requested resource belongs to. This should match the logged in User.
     *
     * @return Exception(on logged in user denied access)|false(on user not logged in)|true(on successful authentication) 
     */
    protected function authenticate($id)
    {
        // redirect to login if not logged in
        if(($user = $this->getUser()) == null){
            return false;
        }

        // access denied if user is not admin, does not own this profile
        if((!$this->get('security.context')->isGranted('ROLE_ADMIN')) && ($user->getId() != $id)){
            throw $this->createAccessDeniedException('Unable to access this page!');
        }

        return true;    
    }
}