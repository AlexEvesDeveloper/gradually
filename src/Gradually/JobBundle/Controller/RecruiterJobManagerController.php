<?php

namespace Gradually\JobBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Gradually\UserBundle\Entity\RecruiterUser;
use Gradually\JobBundle\Entity\Job;
use Gradually\JobBundle\Entity\Location;
use Gradually\JobBundle\Form\JobType;
use Gradually\LibraryBundle\Classes\Doctrine\Point;

/**
 * @Route("/recruiters/{id}/jobs")
 */
class RecruiterJobManagerController extends Controller
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

        // get all jobs belonging to this recruiter
        $recruiter = $this->getDoctrine()->getManager()->getRepository('GraduallyUserBundle:RecruiterUser')->find($id);
        
        return array(
            'recruiter' => $recruiter,
            'jobs' => $recruiter->getJobs()
        );
    }

    /**
     * @Route("/add")
     * @Template()
     */
    public function addAction(Request $request, $id)
    {
        if(!$this->authenticate($id)){
            return $this->redirect($this->generateUrl('gradually_user_default_login'));
        }

        // get the Recruiter
        $recruiter = $this->getDoctrine()->getRepository('GraduallyUserBundle:RecruiterUser')->find($id);

        // check posting credits
        if(!($postingCredits = $recruiter->getPostingCredits())){
            return $this->redirect($this->generateUrl('gradually_purchase_default_index'));
        }

        $job = new Job();
        $form = $this->createForm(new JobType(), $job, array(
            'action' => $this->generateUrl('gradually_job_recruiterjobmanager_add', array(
                'id' => $id
            ))
        ));
        $form->handleRequest($request);
        if($form->isValid()){
            $em = $this->getDoctrine()->getManager();

            // attach the job to this recruiter
            $job->setRecruiter($recruiter);

            // find the location            
            $location = $em->getRepository('GraduallyJobBundle:Location')->findOneByPostcode('LN6');
            $em->persist($location);
            $job->setLocation($location);

            // decrement posting credits
            $recruiter->setPostingCredits(--$postingCredits);

            $em->persist($job);
            $em->persist($recruiter);
            $em->flush();

            // return to the Recruiters Job index view
            return $this->redirect($this->generateUrl('gradually_home_default_index'));
        }

        return array(
            'form' => $form->createView()
        );
    }

    /**
     * @Route("/{jobId}", requirements={"id" = "\d+"})
     * @Template()
     */
    public function viewAction(Request $request, $id, $jobId)
    {
        if(!$this->authenticate($id)){
            return $this->redirect($this->generateUrl('gradually_user_default_login'));
        }

        $job = $this->getDoctrine()->getRepository('GraduallyJobBundle:Job')->findOneBy(
            array(
                'id' => $jobId,
                'recruiter' => $id
            )
        );

        if($job === null){
            // this job id does not belong to the given recruiter
            throw $this->createNotFoundException('Unable to access this page!');
        }

        $form = $this->createForm(new JobType(), $job);
        $form->handleRequest($request);

        if($form->isValid()){
            // redirect to global job view page
            $em = $this->getDoctrine()->getManager();
            $em->persist($job);
            $em->flush();
        }

        return array(
            'form' => $form->createView()
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
