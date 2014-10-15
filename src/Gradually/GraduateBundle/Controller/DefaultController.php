<?php

namespace Gradually\GraduateBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Form\Form as SymForm;

use Gradually\UtilBundle\Entity;
use Gradually\UtilBundle\Form;


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

    	$graduate = $this->getDoctrine()->getManager()->getRepository('GraduallyUtilBundle:GraduateUser')->find($id);

        // check for an Image upload and process if necessary
        $image = new Entity\ProfileImage();
        $pForm = $this->createFormBuilder($image)->add('file')->add('save', 'submit')->getForm();
        $this->handleImageSubmit($graduate, $image, $request, $pForm);

        $qForm = $this->createForm(new Form\QualificationType, new Entity\Qualification);
        $eForm = $this->createForm(new Form\ExperienceType, new Entity\Experience);

        $imagePath = ($image = $graduate->getImage()) === null ? 'uploads/profile_images/default/female.jpg' : $image->getFullPath();
  
        return array(
            'graduate' => $graduate,
            'pForm' => $pForm->createView(),
            'qForm' => $qForm->createView(),
            'eForm' => $eForm->createView(),
            'imagePath' => $imagePath
        );
    }

    /**
     * @Route("/new")
     * @Template()
     */
    public function newAction(Request $request)
    {
        return array(
            'form' => $this->createForm(new Form\GraduateUserType, new Entity\GraduateUser, array(
                'action' => $this->generateUrl('post_graduates')
            ))->createView()
        );
    }

    /**
     * A Recruiter can access a Graduate if they are connected
     *
     * @param RecruiterUser $user
     * @param integer $id Graduate ID
     *
     * @return Bool
     */
    private function recruiterHasAccess(Entity\RecruiterUser $user, $id)
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
    private function handleImageSubmit(Entity\GraduateUser $graduate, Entity\ProfileImage $image, Request $request, SymForm $form)
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
}
