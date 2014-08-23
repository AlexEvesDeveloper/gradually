<?php

namespace Gradually\GraduateBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

use Gradually\UserBundle\Entity\GraduateUser;
use Gradually\UserBundle\Entity\Role;
use Gradually\ProfileBundle\Entity\GraduateProfile;
use Gradually\GraduateBundle\Entity\Qualification;

use Gradually\UserBundle\Form\GraduateUserType;
use Gradually\GraduateBundle\Form\QualificationType;


class DefaultController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
    	$graduates = $this->getDoctrine()->getManager()->getRepository('GraduallyUserBundle:GraduateUser')->findAll();

        return array('graduates' => $graduates);
    }

    /**
     * @Route("/{id}", requirements={"id" = "\d+"})
     * @Template()
     */
    public function viewAction(Request $request, $id)
    {
        // redirect to login if not logged in
        if(($user = $this->getUser()) == null){
            return $this->redirect($this->generateUrl('gradually_user_default_login'));
        }
    	// access denied if user is not admin, does not own this profile, OR IS NOT LINKED WITH THIS PROFILE
    	if((!$this->get('security.context')->isGranted('ROLE_ADMIN')) && ($user->getProfile()->getId() != $id)){
            throw $this->createAccessDeniedException('Unable to access this page!');
        }

    	$graduate = $this->getDoctrine()->getManager()->getRepository('GraduallyProfileBundle:GraduateProfile')->find($id);

        // add new Qualification
        $qual = new Qualification();
        $form = $this->createForm(new QualificationType, $qual);
        $form->handleRequest($request);

        if($form->isValid()){
            // process
            $qual->setGraduate($graduate);
            $em = $this->getDoctrine()->getManager();
            $em->persist($qual);
            $em->flush();
        } 

        return array(
            'graduate' => $graduate,
            'form' => $form->createView()
        );
    }

    /**
     * @Route("/new")
     * @Template()
     */
    public function newAction(Request $request)
    {
        $user = new GraduateUser();
        $form = $this->createForm(new GraduateUserType, $user);

        $form->handleRequest($request);

        if($form->isValid()){
            $em = $this->getDoctrine()->getManager();
            
            // set role to ROLE_NORMAL
            $role = $em->getRepository('GraduallyUserBundle:Role')->findOneByName('normal');
            $user->addRole($role);
            
            // encode the password
            $user->setPassword(password_hash($form->getData()->getPassword(), PASSWORD_BCRYPT, array('cost' => 12)));

            // create an empty GraduateProfile
            $profile = new GraduateProfile();
            $user->setProfile($profile);            
            
            // finish up
            $em->persist($profile);
            $em->persist($user);
            $em->flush();

            // log the new user in
            $token = new UsernamePasswordToken($user, $user->getPassword(), 'secured_area', $user->getRoles());
            $this->container->get('security.context')->setToken($token);

            return $this->redirect($this->generateUrl('gradually_graduate_default_view', array('id' => $user->getProfile()->getId())));
        }


        return array('form' => $form->createView());
    }
}
