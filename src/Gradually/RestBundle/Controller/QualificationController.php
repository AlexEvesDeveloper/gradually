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

class QualificationController extends FOSRestController implements ClassResourceInterface
{
	/**
	 * @View()
	 */
	public function cgetAction(Entity\GraduateUser $graduate)
	{
		return $this->getDoctrine()->getRepository('GraduallyUtilBundle:Qualification')->findAll();
	}

    /**
     * @var Entity\GraduateUser $graduate
     *
     * @View()
     */
    public function getAction(Entity\GraduateUser $graduate, Entity\Qualification $qualification)
    {
        return $this->getDoctrine()->getRepository('GraduallyUtilBundle:Qualification')->findOneBy(
            array(
                'id' => $qualification->getId(),
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

        $qualification = new Entity\Qualification;
        $form = $this->createForm(new Form\QualificationType, $qualification);
        $form->bind($request);

        if(!$form->isValid()){
            return array('form' => $form);
        }
        // Use an existing tag if possible, don't create a duplicate
        $school = $this->getEntityByValue('School', $request->request->get('school')); 
        $course = $this->getEntityByValue('Course', $request->request->get('course'));

        $qualification->setSchool($school);
        $qualification->setCourse($course);       

        $cv = $graduate->getCv();
        $cv->addQualification($qualification);
        $qualification->setCv($cv);

        $em->persist($cv);
        $em->persist($qualification);
        $em->flush();

    	return new Response(json_encode($qualification), Codes::HTTP_CREATED);
    }

    /**
     * If it exists, return it, otherwise create one, persist it, and return it
     */
    private function getEntityByValue($entity, $value)
    {
        $em = $this->getDoctrine()->getManager();

        $repo = sprintf('GraduallyUtilBundle:%s', $entity);
        if(($existingEntity = $em->getRepository($repo)->findOneByValue($value)) !== null){
            // already exists
            return $existingEntity;
        }

        $fullEntity = sprintf('Gradually\UtilBundle\Entity\%s', $entity);
        $entity = new $fullEntity;
        $entity->setValue($value);
        $em->persist($entity);

        return $entity;
    }
}