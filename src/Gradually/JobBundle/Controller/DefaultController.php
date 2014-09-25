<?php

namespace Gradually\JobBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Gradually\GraduateBundle\Entity\Application;
use Gradually\GraduateBundle\Form\ApplicationType;



/**
 * @Route("/jobs")
 */
class DefaultController extends Controller
{
    /**
     * @Route("/{id}")
     * @Template()
     */
    public function viewAction($id)
    {    	
    	$em = $this->getDoctrine()->getManager();
    	$job = $em->getRepository('GraduallyJobBundle:Job')->find($id);

    	// handle the view count
    	if($this->viewCountNeedsUpdating($id)){
	    	$currentCount = $job->getViewCount();
    		$job->setViewCount($currentCount + 1);
    		$em->persist($job);
    		$em->flush();
    	}

    	return array(
    		'job' => $job,
    		'applicationCount' => count($job->getApplications())
    	);
    }

    /**
     * @Route("/{id}/apply")
     * @Template
     */
    public function applyAction(Request $request, $id)
    {
    	// anonymous users can't apply. 
    	if(($user = $this->getUser()) === null){
    		return $this->redirect($this->generateUrl('gradually_user_default_login'));
    	}

        // get the job
        $job = $this->getDoctrine()->getRepository('GraduallyJobBundle:Job')->find($id);

    	// recruiters can't apply. Technically this action will allow admin to apply
    	if($user->getType() == 'RECRUITER'){
    		throw $this->createAccessDeniedException('Unable to access this page!');
    	}

    	$application = new Application();
    	$form = $this->createForm(new ApplicationType(), $application);
    	$form->handleRequest($request);

    	if($form->isValid()){
    		$em = $this->getDoctrine()->getManager();

    		$application->setGraduate($user);
    		$application->setJob($em->getRepository('GraduallyJobBundle:Job')->find($id));

    		$em->persist($application);
    		$em->flush();
    	}

    	return array(
    		'form' => $form->createView(),
            'job' => $job
    	);
    }

    /**
     * This function attempts to ensure the view count is for unique visits, and not include page refreshes.
     * Does this visitor have a view_count cookie for this job?
     *   Yes: don't increment the view count 
     *   No: set a 60 minute cookie
	 *
     * @param integer $id the job id.
     */
    protected function viewCountNeedsUpdating($id)
    {
    	$request = Request::createFromGlobals();
    	if($request->cookies->has('job_view') && $request->cookies->get('job_view') == $id){
    		return false;
    	}

    	setcookie('job_view', $id, time() + 3600);

    	return true;
    }
}