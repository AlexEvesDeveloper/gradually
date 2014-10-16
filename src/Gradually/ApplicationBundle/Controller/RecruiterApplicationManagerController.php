<?php

namespace Gradually\ApplicationBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Gradually\UtilBundle\Entity;
use Gradually\UtilBundle\Form;

/**
 * @Route("/applications")
 */
class RecruiterApplicationManagerController extends Controller
{
    /**
     * Decline an application
     *
     * @Route("/decline/{applicationId}")
     * @Method({"POST"})
     */
    public function declineApplication($applicationId)
    {
    	$em = $this->getDoctrine()->getManager();
    	$application = $em->getRepository('GraduallyUtilBundle:Application')->find($applicationId);
    	$application->setStatus('DECLINED');
    	$em->persist($application);
    	$em->flush();

    	return new Response(json_encode(array('id' => $applicationId)));
    }

    /**
     * Decline an application
     *
     * @Route("/shortlist/{applicationId}")
     * @Method({"POST"})
     */
    public function shortlistApplication($applicationId)
    {
    	$em = $this->getDoctrine()->getManager();
    	$application = $em->getRepository('GraduallyUtilBundle:Application')->find($applicationId);
    	$application->setStatus('SHORTLISTED');
    	$em->persist($application);
    	$em->flush();

    	return new Response(json_encode(array('id' => $applicationId)));
    }
}