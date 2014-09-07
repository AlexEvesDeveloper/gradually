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
	// initialise empty search results
	$graduates = array();
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
	    	    $em->flush();
		}
	    }

	    $queryString = '
		SELECT g, q, u, un, d FROM GraduallyProfileBundle:GraduateProfile g
		JOIN g.user u
	    	JOIN g.qualifications q
		JOIN q.university un
		JOIN q.degree d
		WHERE u.isActive = :isActive
	    ';

	    $queryParams = array();
	    $queryParams['isActive'] = true;

	    if(($university = $form->getData()->getUniversity()) !== null){
	   	$queryString .= " AND un.id = :university";
		$queryParams['university'] = $university->getId(); 
	    }

	    if(($degree = $form->getData()->getDegree()) !== null){
	    	$queryString .= " AND d.id = :degree";
	    	$queryParams['degree'] = $degree->getId();
	    }

	    if(($yearAttained = $form->getData()->getYearAttained()) !== null){
		$queryString .= " AND q.yearAttained = :year";
		$queryParams['year']  = sprintf('%s-01-01', $yearAttained);
	    }

	    if(($result = $form->getData()->getResult()) !== null){
	    	$queryString .= " AND q.result = :result";
	        $queryParams['result'] = $result;
	    }
	    //print "<pre>" . $queryString . "<br>";

	    $queryString .= " ORDER BY g.id ASC";

	    $query = $this->getDoctrine()->getManager()->createQuery($queryString)->setParameters($queryParams);
	    $graduates = $query->getResult();
	}

	return array(
	    'form' => $form->createView(),
	    'graduates' => $graduates
	);
    }

    /**
     * @Route("/results")
     * @Template()
     */
    public function resultsAction($results)
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
