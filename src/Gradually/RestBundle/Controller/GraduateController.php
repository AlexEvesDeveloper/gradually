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

class GraduateController extends BaseController
{
	/**
	 * @View()
	 */
	public function cgetAction()
	{
		return $this->getDoctrine()->getRepository('GraduallyUtilBundle:GraduateUser')->findAll();
	}


    /**
     * @var Entity\GraduateUser $graduate
     *
     * @View()
     */
    public function getAction(Entity\GraduateUser $graduate)
    {
    	return $graduate;
    }
    
    /**
     * @var Request $request
     */
    public function cpostAction(Request $request)
    {
	  	$em = $this->getDoctrine()->getManager();
    	
    	$graduate = new Entity\GraduateUser();
    	$form = $this->createForm(new Form\GraduateUserType, $graduate);
    	$form->bind($request);

    	if(!$form->isValid()){
    		return array('form' => $form);
    	}

        // encode the password
        $graduate->setPassword(password_hash($form->getData()->getPassword(), PASSWORD_BCRYPT, array('cost' => 12)));

        // manually set the e-mail as the username
        $graduate->setUsername($form->getData()->getEmail());

        // create an empty CV for them
        $cv = new Entity\Cv();
        $cv->setGraduate($graduate);

        $em->persist($cv);
    	$em->persist($graduate);
    	$em->flush();

        // log the new user in
        $token = new UsernamePasswordToken($graduate, $graduate->getPassword(), 'secured_area', $graduate->getRoles());
        $this->container->get('security.context')->setToken($token);
    
        return $this->redirect($this->generateUrl('gradually_home_default_index'));

        // uncomment the below if I decide to post graduates via REST
    	// return new Response(json_encode($graduate), Codes::HTTP_CREATED);
    }
}