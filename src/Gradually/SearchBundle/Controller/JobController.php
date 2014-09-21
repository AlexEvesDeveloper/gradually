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
		
		return array(
	    	'form' => $form->createView(),
	    	'jobs' => $result
		);
	}
}
