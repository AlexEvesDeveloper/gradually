<?php

namespace Gradually\GraduateBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Form\Form;

use Gradually\UserBundle\Entity\GraduateUser;
use Gradually\UserBundle\Entity\Role;
use Gradually\GraduateBundle\Entity\Qualification;

use Gradually\UserBundle\Form\GraduateUserType;
use Gradually\GraduateBundle\Form\QualificationType;
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

    	// access denied if user is not admin and does not own this profile, and is not a recruiter...
    	if((!$this->get('security.context')->isGranted('ROLE_ADMIN')) && ($user->getId() != $id) && ($user->getType() != 'RECRUITER')){
            throw $this->createAccessDeniedException('Unable to access this page!');
        }

        // ... because if they are a recruiter, they may have access to this graduate...
        if($user->getType() == 'RECRUITER' && !$this->recruiterHasAccess($user, $id)){
            throw $this->createAccessDeniedException('Unable to access this page!');

        } 

    	$graduate = $this->getDoctrine()->getManager()->getRepository('GraduallyUserBundle:GraduateUser')->find($id);

        // check for an Image upload and process if necessary
        $image = new ProfileImage();
        $pForm = $this->createFormBuilder($image)->add('file')->add('save', 'submit')->getForm();
        $this->handleImageSubmit($graduate, $image, $request, $pForm);

        // add new Qualification
        $qualification = new Qualification();
        $qForm = $this->createForm(new QualificationType, $qualification);
        $this->handleQualificationSubmit($graduate, $qualification, $request, $qForm);


        $imagePath = ($image = $graduate->getImage()) === null ? 'uploads/profile_images/default/female.jpg' : $image->getFullPath();
  
        return array(
            'graduate' => $graduate,
            'pForm' => $pForm->createView(),
            'qForm' => $qForm->createView(),
            'imagePath' => $imagePath
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
            $role = $em->getRepository('GraduallyUserBundle:Role')->findOneByName('graduate');
            $user->addRole($role);
            
            // encode the password
            $user->setPassword(password_hash($form->getData()->getPassword(), PASSWORD_BCRYPT, array('cost' => 12)));

            // manually set the e-mail as the username
            $user->setUsername($form->getData()->getEmail());

            // finish up
            $em->persist($user);
            $em->flush();

            // log the new user in
            $token = new UsernamePasswordToken($user, $user->getPassword(), 'secured_area', $user->getRoles());
            $this->container->get('security.context')->setToken($token);

            return $this->redirect($this->generateUrl('gradually_graduate_default_view', array('id' => $user->getId())));
        }

        return array('form' => $form->createView());
    }

    /**
     * A Recruiter can access a Graduate if they are connected
     *
     * @param RecruiterUser $user
     * @param integer $id Graduate ID
     *
     * @return Bool
     */
    private function recruiterHasAccess(\Gradually\UserBundle\Entity\RecruiterUser $user, $id)
    {
        $graduatesUserCanAccess = $user->getGraduates();
        foreach($graduatesUserCanAccess as $graduate){
            if($graduate->getId() == $id){
                return true;
            }
        }

        // didn't find any matches, so return false
        return false;
    }

    /**
     * Upload the User's new Image.
     *
     * @param GraduateUser $graduate
     * @param ProfileImage $image.
     * @param Request $request.
     * @param Form $form
     */
    private function handleImageSubmit(GraduateUser $graduate, ProfileImage $image, Request $request, Form $form)
    {
        $form->handleRequest($request);
        
        if($form->isValid()){
            $em = $this->getDoctrine()->getManager();
            // upload image, first remove their old one, if they had one        
            if(($oldImage = $graduate->getImage()) !== null){
                $em->remove($oldImage);
                $em->flush();
            }     

            $image->setUser($graduate);
            $graduate->setProfileImage($image);            
            $em->persist($image);
            $em->flush();
        }     
    }  

    /**
     * Upload the User's new Qualification.
     *
     * @param GraduateUser $graduate
     * @param ProfileImage $image.
     * @param Request $request.
     * @param Form $form
     */
    private function handleQualificationSubmit(GraduateUser $graduate, Qualification $qualification, Request $request, Form $form)
    {
        $form->handleRequest($request);

        if($form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $qualification->setGraduate($graduate);
            
            $em->persist($qualification);
            $em->flush();
        }     
    }      
}
