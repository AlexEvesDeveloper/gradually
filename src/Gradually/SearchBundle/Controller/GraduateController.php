<?php

namespace Gradually\SearchBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Gradually\UtilBundle\Entity\GraduateSearch;
use Gradually\UtilBundle\Form\GraduateSearchType;
use Gradually\SearchBundle\Classes\GraduateSearchHandler;

/**
* @Route("/graduates")
*/
class GraduateController extends Controller
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
		$graduateSearch = new GraduateSearch();
		$form = $this->createForm(new GraduateSearchType(), $graduateSearch);

		$form->handleRequest($request);
		if($form->isValid()){
	
	    	// redirect to login if not logged in
	    	if(($user = $this->getUser()) === null){
	    		return $this->redirect($this->generateUrl('gradually_user_default_login'));
	    	}		
	
			$result = $em->getRepository('GraduallyUtilBundle:GraduateUser')->search($form);
		}
	
		// by default, show all. No ordering at present
		if(empty($result)){
			$result = $em->getRepository('GraduallyUtilBundle:GraduateUser')->findAll();
		}
	
		return array(
	    	'form' => $form->createView(),
	    	'graduates' => $result
		);
	}	
}
