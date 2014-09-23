<?php

namespace Gradually\GraduateBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

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
    	// access denied if user is not admin, does not own this profile, OR IS NOT LINKED WITH THIS PROFILE
    	if((!$this->get('security.context')->isGranted('ROLE_ADMIN')) && ($user->getId() != $id)){
            throw $this->createAccessDeniedException('Unable to access this page!');
        }

    	$graduate = $this->getDoctrine()->getManager()->getRepository('GraduallyUserBundle:GraduateUser')->find($id);

        // add a profile image
        $image = new ProfileImage();
        $pForm = $this->createFormBuilder($image)->add('file')->add('save', 'submit')->getForm();
        $pForm->handleRequest($request);
        if($pForm->isValid()){
            $em = $this->getDoctrine()->getManager();
            // upload image, first remove their old one, if they had one
            
            if(($oldImage = $user->getImage()) !== null){
                $em->remove($oldImage);
                $em->flush();
            }
                     
            $image->setUser($user);
            $user->setProfileImage($image);
            
            $em->persist($image);
            $em->flush();            
        }

        if(($image = $user->getImage()) === null){
            $imagePath = 'uploads/profile_images/default/female.jpg';
        }else{
            $imageFilename = $image->getId() . '.' . $image->getPath();
            $imagePath = 'uploads/profile_images/' . $imageFilename;
        }
        // add new Qualification
        $qual = new Qualification();
        $qForm = $this->createForm(new QualificationType, $qual);
        $qForm->handleRequest($request);

        if($qForm->isValid()){
            // process
            $qual->setGraduate($graduate);
            $em = $this->getDoctrine()->getManager();
            $em->persist($qual);
            $em->flush();
        }

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
}
