<?php

namespace Gradually\SearchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
* @Route("/graduates")
*/
class GraduateController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        // redirect to login if not logged in
        if(($user = $this->getUser()) == null){
            return $this->redirect($this->generateUrl('gradually_user_default_login'));
        }

        // recruiters without search credits redirect to purchase page
        if($user->getType() == 'RECRUITER'){
            if(!$user->getProfile()->getSearchCredits()){
                return $this->redirect($this->generateUrl('gradually_purchase_default_index'));
            }
        }

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
