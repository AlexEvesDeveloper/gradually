<?php

namespace Gradually\RestBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Util\Codes;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use Gradually\UtilBundle\Entity;
use Gradually\UtilBundle\Form;

class JobController extends BaseController
{

    /**
     * @var Entity\RecruiterUser $graduate
     *
     * @View()
     */
    public function cgetAction(Entity\RecruiterUser $recruiter)
    {
        return $this->getDoctrine()->getRepository('GraduallyUtilBundle:Job')->findBy(
            array(
                'recruiter' => $recruiter->getId()
            )
        );
    }

    /**
     * @var Entity\RecruiterUser $recruiter
     * @var Entity\Job
     *
     * @View()
     */
    public function getAction(Entity\RecruiterUser $recruiter, Entity\Job $job)
    {
        return $this->getDoctrine()->getRepository('GraduallyUtilBundle:Job')->findOneBy(
            array(
                'id' => $job->getId(),
                'recruiter' => $recruiter->getId(),
            )
        );
    } 

    /**
     * @var Request $request
     * @var Entity\RecruiterUser $recruiter
     */  
    public function postAction(Request $request, Entity\RecruiterUser $recruiter)
    {
        $em = $this->getDoctrine()->getManager();

        $postcode = $request->request->get('postcode');
        $request->request->remove('postcode');

        $job = new Entity\Job();
        $form = $this->createForm(new Form\JobType, $job);
        $form->bind($request);

        if(!$form->isValid()){
            return array('form' => $form);
        }

        $job->setLocation($em->getRepository('GraduallyUtilBundle:Location')->findOneByPostcode($postcode));
        $job->setRecruiter($recruiter);  

        $em->persist($job);
        $em->flush();

        return new Response(json_encode($recruiter), Codes::HTTP_CREATED);
    }
}