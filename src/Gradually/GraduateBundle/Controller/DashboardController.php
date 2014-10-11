<?php

namespace Gradually\GraduateBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\Form;

use Gradually\JobBundle\Entity\JobTitleTag;
use Gradually\JobBundle\Form\JobTitleTagType;
use Gradually\UserBundle\Entity\GraduateUser;

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
		// add qualifications
        $jobTitleTag = new JobTitleTag();
        $jTTForm = $this->createForm(new JobTitleTagType, $jobTitleTag, array(
            'action' => $this->generateUrl('gradually_graduate_dashboard_welcomewizard')
        ));
        $this->handleJobTitleTagSubmit($this->getUser(), $jobTitleTag, $request, $jTTForm);

        return array(
        	'jTTForm' => $jTTForm->createView(),
        );
	}

    /**
     * Upload the User's new JobTitleTag
     *
     * @param GraduateUser $graduate
     * @param JobTitleTag $jobTitleTag
     * @param Request $request.
     * @param Form $form
     */
    private function handleJobTitleTagSubmit(GraduateUser $graduate, JobTitleTag $jobTitleTag, Request $request, Form $form)
    {
        $form->handleRequest($request);

        if($form->isValid()){
            $em = $this->getDoctrine()->getManager();
            
            // Use an existing tag if possible, don't create a duplicate
            if(($existingTag = $em->getRepository('GraduallyJobBundle:JobTitleTag')->findOneByTitle($form->getData()->getTitle())) !== null){
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