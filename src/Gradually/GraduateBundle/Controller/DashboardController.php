<?php

namespace Gradually\GraduateBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Form\Form as SymForm;

use Gradually\UtilBundle\Entity;
use Gradually\UtilBundle\Form;

/**
 * @Route("/dashboard")
 */
class DashboardController extends Controller
{
	/**
	 * @Route()
	 * @Template()
	 */
	public function welcomeWizardAction(Request $request)
	{
        // qualification
        $qual = new Entity\Qualification();
        $qForm = $this->createForm(new Form\QualificationType, $qual);

        // experience
        $experience = new Entity\Experience();
        $eForm = $this->createForm(new Form\ExperienceType, $experience);

        if($request->getMethod() == 'POST'){
            if($request->request->has('gradually_utilbundle_qualification')){
                $this->saveQualification($this->getUser(), $qual, $request, $qForm);
            }else if($request->request->has('gradually_utilbundle_experience')){
                $this->saveExperience($this->getUser(), $experience, $request, $eForm);
            }
        }

        return array(
            'qForm' => $qForm->createView(),
            'eForm' => $eForm->createView(),
        ); 
	}

    private function saveQualification(Entity\GraduateUser $graduate, Entity\Qualification $qualification, Request $request, SymForm $form)
    {
         $form->handleRequest($request);

        if($form->isValid()){
            $em = $this->getDoctrine()->getManager();
                    
            $cv = $graduate->getCv();
            $cv->addQualification($qualification);
            $qualification->setCv($cv);

            $em->persist($cv);
            $em->persist($qualification);
            $em->flush();
        }         
    }

    private function saveExperience(Entity\GraduateUser $graduate, Entity\Experience $experience, Request $request, SymForm $form)
    {
         $form->handleRequest($request);

        if($form->isValid()){
            $em = $this->getDoctrine()->getManager();
                    
            $cv = $graduate->getCv();
            $cv->addExperience($experience);
            $experience->setCv($cv);

            $em->persist($cv);
            $em->persist($experience);
            $em->flush();
        }         
    }

    /**
     * Update the wizard flag for this User.
     *
     * @Route("/complete-wizard")
     * @Method({"POST"})
     */
    public function completeWizardAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $graduate = $em->getRepository('GraduallyUtilBundle:GraduateUser')->find($request->request->get('id'));
        $graduate->setCompletedWelcomeWizard(true);
        $em->persist($graduate);
        $em->flush();
    }

    /**
     * Upload the User's new JobTitleTag
     *
     * @param GraduateUser $graduate
     * @param JobTitleTag $jobTitleTag
     * @param Request $request.
     * @param Form $form
     */
    private function handleJobTitleTagSubmit(GraduateUser $graduate, JobTitleTag $jobTitleTag, Request $request, SymForm $form)
    {
        $form->handleRequest($request);

        if($form->isValid()){
            $em = $this->getDoctrine()->getManager();
            
            // Use an existing tag if possible, don't create a duplicate
            if(($existingTag = $em->getRepository('GraduallyUtilBundle:JobTitleTag')->findOneByTitle($form->getData()->getTitle())) !== null){
                $jobTitleTag = $existingTag;
            }else{
                $em->persist($jobTitleTag);                
            }

            // Do nothing if the relationship exists
            if($graduate->getJobTitleTags()->contains($jobTitleTag)){
                return;
            }
            
            $graduate->addJobTitleTag($jobTitleTag);
            $jobTitleTag->addGraduate($graduate);

            $em->persist($graduate);
            $em->persist($jobTitleTag);
            $em->flush();
        }     
    }
}