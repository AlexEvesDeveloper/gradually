<?php

namespace Gradually\RecruiterBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

use Gradually\UserBundle\Entity\RecruiterUser;
use Gradually\UserBundle\Form\RecruiterUserType;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
    	$recruiters = $this->getDoctrine()->getManager()->getRepository('GraduallyUserBundle:RecruiterUser')->findAll();

        return array('recruiters' => $recruiters);
    }

    /**
     * @Route("/{id}", requirements={"id" = "\d+"})
     * @Template()
     */
    public function viewAction($id)
    {
    	$recruiter = $this->getDoctrine()->getManager()->getRepository('GraduallyUserBundle:RecruiterUser')->find($id);

        return array(
            'recruiter' => $recruiter,
            'userType' => $this->getUser()->getType()
        );
    }

    /**
     * @Route("/new")
     * @Template()
     */
    public function newAction(Request $request)
    {
         $user = new RecruiterUser();
         $form = $this->createForm(new RecruiterUserType, $user);
 
         $form->handleRequest($request);
 
        if($form->isValid()){
            $em = $this->getDoctrine()->getManager();
 
            // set role to ROLE_NORMAL
            $role = $em->getRepository('GraduallyUserBundle:Role')->findOneByName('recruiter');
            $user->addRole($role);
 
            // encode the password
            $user->setPassword(password_hash($form->getData()->getPassword(), PASSWORD_BCRYPT, array('cost' => 12)));

            // manually set the username as the companyname
            $user->setUsername($form->getData()->getCompanyName());
 
            // finish up
            $em->persist($user);
            $em->flush();
 
            // log the new user in
            $token = new UsernamePasswordToken($user, $user->getPassword(), 'secured_area', $user->getRoles());
            $this->container->get('security.context')->setToken($token);
 
            return $this->redirect($this->generateUrl('gradually_recruiter_default_view', array('id' => $user->getId())));
        }

        return array('form' => $form->createView());
    }

    /**
     * Subscribe the recruiter to the graduates list of recruiters 
     *
     * @Route("/watch/{recruiterId}/{graduateId}", requirements={"recruiterId" = "\d+", "graduateId" = "\d+"})")
     */
    public function watchAction($recruiterId, $graduateId)
    {
        $em = $this->getDoctrine()->getManager();
        
        $graduate = $em->getRepository('GraduallyUserBundle:GraduateUser')->find($graduateId);
        $graduate->addRecruiter($em->getRepository('GraduallyUserBundle:RecruiterUser')->find($recruiterId));

        $em->persist($graduate);
        $em->flush();

        // all done, redirect to the page we came from
        return $this->redirect($this->generateUrl('gradually_recruiter_default_view', array('id' => $recruiterId)));
    }
}
