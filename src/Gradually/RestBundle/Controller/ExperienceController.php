<?php

namespace Gradually\RestBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Util\Codes;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;

use Gradually\UtilBundle\Entity;
use Gradually\UtilBundle\Form;

class ExperienceController extends BaseController
{
	/**
	 * @View()
	 */
	public function cgetAction(Entity\GraduateUser $graduate, Entity\Cv $cv)
	{
        if(!$this->verifyEntity($graduate, $cv)){
            return $this->view(null, Codes::HTTP_NOT_FOUND);
        }

		return $this->getDoctrine()->getRepository('GraduallyUtilBundle:Experience')->findBy(
            array(
                'cv' => $cv->getId()
            )
        );
	}

    /**
     * @View()
     */
    public function getAction(Entity\GraduateUser $graduate, Entity\Cv $cv, Entity\Experience $experience)
    {
        if(!$this->verifyEntity($graduate, $cv)){
            return $this->view(null, Codes::HTTP_NOT_FOUND);
        }

        return $this->getDoctrine()->getRepository('GraduallyUtilBundle:Experience')->findOneBy(
            array(
                'id' => $experience->getId(),
                'cv' => $graduate->getCv()->getId()
            )
        );
    }
    
    /**
     * @var Request $request
     */
    public function cpostAction(Request $request, Entity\GraduateUser $graduate, Entity\Cv $cv)
    {
        if(!$this->verifyEntity($graduate, $cv)){
            return $this->view(null, Codes::HTTP_NOT_FOUND);
        }

        $em = $this->getDoctrine()->getManager();

        $experience = new Entity\Experience;
        $form = $this->createForm(new Form\ExperienceType, $experience);
        $form->bind($request);

        if(!$form->isValid()){
            return array('form' => $form);
        }

        $cv->addExperience($experience);

        $experience->setCv($cv);

        $em->persist($cv);
        $em->persist($experience);
        $em->flush();

    	return new Response(json_encode($experience), Codes::HTTP_CREATED);
    }

    private function verifyEntity(Entity\GraduateUser $graduate, Entity\Cv $cv)
    {
        $entity = $this->getDoctrine()->getRepository('GraduallyUtilBundle:Cv')->findOneBy(
            array(
                'id' => $cv->getId(),
                'graduate' => $graduate->getId()
            )
        );

        return (bool) $entity;
    }
}