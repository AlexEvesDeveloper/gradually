<?php

namespace Gradually\RestBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Util\Codes;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

use Gradually\UtilBundle\Entity;
use Gradually\UtilBundle\Form;

class RecruiterController extends BaseController
{
	/**
	 * @View()
	 */
	public function cgetAction()
	{
		return $this->getDoctrine()->getRepository('GraduallyUtilBundle:RecruiterUser')->findAll();
	}


    /**
     * @var Entity\GraduateUser $graduate
     *
     * @View()
     */
    public function getAction(Entity\RecruiterUser $recruiter)
    {
    	return $recruiter;
    }
    
    /**
     * @var Request $request
     */
    public function cpostAction(Request $request)
    {
	  	$em = $this->getDoctrine()->getManager();

        $recruiter = new Entity\RecruiterUser();
        $form = $this->createForm(new Form\RecruiterUserType, $recruiter);
        $form->bind($request);


        if(!$form->isValid()){
            return array('form' => $form);
        }


        // encode the password
        $recruiter->setPassword(password_hash('password', PASSWORD_BCRYPT, array('cost' => 12)));

        // manually set the e-mail as the username
        $recruiter->setUsername($form->getData()->getCompanyName());

        // set the role
        $recruiter->addRole($em->getRepository('GraduallyUtilBundle:Role')->findOneByName('recruiter'));

    	$em->persist($recruiter);
    	$em->flush();

        // log the new user in
        //$token = new UsernamePasswordToken($graduate, $graduate->getPassword(), 'secured_area', $graduate->getRoles());
        //$this->container->get('security.context')->setToken($token);
    
        //return $this->redirect($this->generateUrl('gradually_home_default_index'));

        // uncomment the below if I decide to post graduates via REST
    	return new Response(json_encode($recruiter), Codes::HTTP_CREATED);
    }
}
