<?php

namespace Gradually\SearchBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Gradually\UtilBundle\Entity\JobSearch;
use Gradually\UtilBundle\Form\JobSearchType;
use Gradually\SearchBundle\Classes\JobSearchHandler;

/**
* @Route("/jobs")
*/
class JobController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction(Request $request)
    {
		// initialise empty search results
		$result = array();
		$jobSearch = new JobSearch();
		$form = $this->createForm(new JobSearchType(), $jobSearch, array(
			'action' => $this->generateUrl('gradually_search_job_index')
		));

		$form->handleRequest($request);
		if($form->isValid()){
	    	$em = $this->getDoctrine()->getManager();

	    	$result = $em->getRepository('GraduallyUtilBundle:Job')->search($form);
		}

		$locations = $this->getDoctrine()->getRepository('GraduallyUtilBundle:Location')->findAll();
		// create a repo function to get town names, but for now...
		$towns = array();
		foreach($locations as $l){
			$towns[] = $l->getTown();
			$towns[] = $l->getPostcode();
		}
		
		$towns = array_unique($towns);


		return array(
	    	'form' => $form->createView(),
	    	'jobs' => $result,
	    	'towns' => json_encode($towns)
		);
	}
}
