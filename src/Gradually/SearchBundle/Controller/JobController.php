<?php

namespace Gradually\SearchBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Gradually\SearchBundle\Entity\JobSearch;
use Gradually\SearchBundle\Form\JobSearchType;
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
		$form = $this->createForm(new JobSearchType(), $jobSearch);

		$form->handleRequest($request);
		if($form->isValid()){
	    		$em = $this->getDoctrine()->getManager();


	    		$sh = $this->container->get('job_search_handler');
	    		$orderBy = array('property' => 'job.id', 'order' => 'ASC');
                	$sh->prepareSearch($form, $orderBy);
                	$result = $sh->execute();	
		}

		$locations = $this->getDoctrine()->getRepository('GraduallyJobBundle:Location')->findAll();
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
