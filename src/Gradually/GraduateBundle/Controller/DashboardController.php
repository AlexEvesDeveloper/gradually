<?php

namespace Gradually\GraduateBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\Form;

use Gradually\GraduateBundle\Entity\Qualification;
use Gradually\GraduateBundle\Form\QualificationType;
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
        $qualification = new Qualification();
        $qForm = $this->createForm(new QualificationType, $qualification, array(
            'action' => $this->generateUrl('gradually_graduate_dashboard_welcomewizard')
        ));
        $this->handleQualificationSubmit($this->getUser(), $qualification, $request, $qForm);

        return array(
        	'qForm' => $qForm->createView(),
        );
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