<?php

namespace Gradually\SearchBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Gradually\SearchBundle\Entity\RecruiterSearch;
use Gradually\SearchBundle\Form\RecruiterSearchType;
use Gradually\SearchBundle\Classes\RecruiterSearchHandler;

/**
* @Route("/recruiters")
*/
class RecruiterController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction(Request $request)
    {
		// initialise empty search results
	    $em = $this->getDoctrine()->getManager();
		$result = array();
		$recruiterSearch = new RecruiterSearch();
		$form = $this->createForm(new RecruiterSearchType(), $recruiterSearch);

		$form->handleRequest($request);
		if($form->isValid()){
	
	    	// redirect to login if not logged in
	    	if(($user = $this->getUser()) === null){
	    		return $this->redirect($this->generateUrl('gradually_user_default_login'));
	    	}		
	
			$result = $em->getRepository('GraduallyUserBundle:RecruiterUser')->search($form);
		}
	
		// by default, show all. No ordering at present
		if(empty($result)){
			$result = $em->getRepository('GraduallyUserBundle:RecruiterUser')->findAll();
		}
	
		return array(
	    	'form' => $form->createView(),
	    	'recruiters' => $result
		);
	}	
}