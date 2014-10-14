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
    
            // Use an existing tag if possible, don't create a duplicate
            $schoolInput = $request->request->get('gradually_utilbundle_qualification')['school'];
            $school = $this->getEntityByValue('School', $schoolInput); 


            $courseInput = $request->request->get('gradually_utilbundle_qualification')['course']; 
            $course = $this->getEntityByValue('Course', $courseInput);

            $qualification->setSchool($school);
            $qualification->setCourse($course);
                    
            $cv = $graduate->getCv();
            $cv->addQualification($qualification);
            $qualification->setCv($cv);

            $em->persist($cv);
            $em->persist($qualification);
            $em->flush();
        }         
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
}