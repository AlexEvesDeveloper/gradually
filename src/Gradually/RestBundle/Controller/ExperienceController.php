<?php

namespace Gradually\RestBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Util\Codes;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

use Gradually\UtilBundle\Entity;
use Gradually\UtilBundle\Form;

class ExperienceController extends FOSRestController implements ClassResourceInterface
{
	/**
	 * @View()
	 */
	public function cgetAction(Entity\GraduateUser $graduate)
	{
		return $this->getDoctrine()->getRepository('GraduallyUtilBundle:Experience')->findAll();
	}

    /**
     * @var Entity\GraduateUser $graduate
     *
     * @View()
     */
    public function getAction(Entity\GraduateUser $graduate, Entity\Experience $experience)
    {
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
    public function cpostAction(Request $request, Entity\GraduateUser $graduate)
    {
        $em = $this->getDoctrine()->getManager();

        $experience = new Entity\Experience;
        $form = $this->createForm(new Form\ExperienceType, $experience);
        $form->bind($request);

        if(!$form->isValid()){
            return array('form' => $form);
        }

        $cv = $graduate->getCv();
        $cv->addExperience($experience);

        $experience->setCv($cv);

        $em->persist($cv);
        $em->persist($experience);
        $em->flush();

    	return new Response(json_encode($experience), Codes::HTTP_CREATED);
    }
}