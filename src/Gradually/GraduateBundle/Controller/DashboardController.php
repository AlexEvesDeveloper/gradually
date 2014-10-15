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
}