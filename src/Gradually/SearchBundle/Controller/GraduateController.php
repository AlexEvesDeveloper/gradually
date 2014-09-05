<?php

namespace Gradually\SearchBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Gradually\SearchBundle\Entity\GraduateSearch;
use Gradually\SearchBundle\Form\GraduateSearchType;

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
	$graduateSearch = new GraduateSearch();
	$form = $this->createForm(new GraduateSearchType(), $graduateSearch);

	$form->handleRequest($request);
	if($form->isValid()){
	    $em = $this->getDoctrine()->getManager();

	    // redirect to login if not logged in
	    if(($user = $this->getUser()) == null){
	    	return $this->redirect($this->generateUrl('gradually_user_default_login'));
	    }		

	    // recruiters without search credits redirect to purchase page, otherwise reduce one credit
	    if($user->getType() == 'RECRUITER'){
	    	if(!$user->getProfile()->getSearchCredits()){
		    // insufficient credits
		    return $this->redirect($this->generateUrl('gradually_purchase_default_index'));
		}else{
		    // decrement credits by one
		    $currentCredits = $user->getProfile()->getSearchCredits();
		    $user->getProfile()->setSearchCredits(--$currentCredits);
		    $em->persist($user);
		}
	    }

	    $em->flush();
	}

	return array(
	    'form' => $form->createView()
	);
    }

    /**
     * @Route("/results")
     * @Template()
     */
    public function resultsAction()
    {
	$query = $this->getDoctrine()->getManager()
        	->createQuery('
				SELECT g, q, u FROM GraduallyProfileBundle:GraduateProfile g	
				JOIN g.qualifications q
				JOIN q.university u
				WHERE u.name = :university
        	')->setParameter('university', 'University of London');

        $graduates = $query->getResult();

        return array(
        	'graduates' => $graduates
        );
    }
}