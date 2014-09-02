<?php

namespace Gradually\JobBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/recruiters/{recId}")
 */
class RecruiterJobManagerController extends Controller
{
    /**
     * @Route("/jobs")
     * @Template()
     */
    public function indexAction($recId)
    {
        if(!$this->authenticate($recId)){
            return $this->redirect($this->generateUrl('gradually_user_default_login'));
        }

        // get all jobs belonging to this recruiter
        $recruiter = $this->getDoctrine()->getManager()->getRepository('GraduallyProfileBundle:RecruiterProfile')->find($recId);
        $jobs = $recruiter->getJobs();
        return array('jobs' => $jobs);
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
        if((!$this->get('security.context')->isGranted('ROLE_ADMIN')) && ($user->getProfile()->getId() != $id)){
            throw $this->createAccessDeniedException('Unable to access this page!');
        }

        return true;    
    }
}
