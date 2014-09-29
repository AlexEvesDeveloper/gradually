<?php

namespace Gradually\RecruiterBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Form\Form;

use Gradually\UserBundle\Entity\RecruiterUser;
use Gradually\UserBundle\Form\RecruiterUserType;
use Gradually\UserBundle\Entity\ProfileImage;

class DefaultController extends Controller
{
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
        
    	$recruiter = $this->getDoctrine()->getManager()->getRepository('GraduallyUserBundle:RecruiterUser')->find($id);

        // check for an Image upload and process if necessary
        $image = new ProfileImage();
        $pForm = $this->createFormBuilder($image)->add('file')->add('save', 'submit')->getForm();
        $this->handleImageSubmit($recruiter, $image, $request, $pForm);


        $userType = $this->getUser() == null ? null : $this->getUser()->getType();
        $imagePath = ($image = $recruiter->getImage()) === null ? 'uploads/profile_images/default/female.jpg' : $image->getFullPath();

        return array(
            'recruiter' => $recruiter,
            'userType' => $userType,
            'imagePath' => $imagePath,
            'pForm' => $pForm->createView(),
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

    /**
     * Upload the User's new Image.
     *
     * @param RecruiterUser $graduate
     * @param ProfileImage $image.
     * @param Request $request.
     * @param Form $form
     */
    private function handleImageSubmit(RecruiterUser $graduate, ProfileImage $image, Request $request, Form $form)
    {
        $form->handleRequest($request);
        
        if($form->isValid()){
            $em = $this->getDoctrine()->getManager();
            // upload image, first remove their old one, if they had one        
            if(($oldImage = $recruiter->getImage()) !== null){
                $em->remove($oldImage);
                $em->flush();
            }     

            $image->setUser($recruiter);
            $recruiter->setProfileImage($image);            
            $em->persist($image);
            $em->flush();
        }     
    } 
}
