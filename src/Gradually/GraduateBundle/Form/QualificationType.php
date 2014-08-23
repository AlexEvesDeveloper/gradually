<?php

namespace Gradually\GraduateBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Doctrine\Orm\EntityRepository;

use Gradually\UtilBundle\Entity\University;

class QualificationType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'university', 'entity', array(
            'class' => 'GraduallyUtilBundle:University',
            'query_builder' => function(EntityRepository $er ){
                return $er->createQueryBuilder('u')
                          ->orderBy('u.name', 'ASC');
            } 
        ));

        $formModifier = function(FormInterface $form, University $university = null){
            $degrees = ($university === null) ? array() : $university->getDegrees();
            
            $form->add('degree', 'entity', array(
                'class' => 'GraduallyUtilBundle:Degree',
                'choices' => $degrees,
            ));
        };
 
        // degrees are dependent on the university that was just chosen
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function(FormEvent $event) use ($formModifier){
                $qualification = $event->getData();
                $formModifier($event->getForm(), $qualification->getUniversity());
            }
        );
    
        $builder->get('university')->addEventListener(
            FormEvents::POST_SUBMIT,
            function(FormEvent $event) use ($formModifier){
                $university = $event->getForm()->getData();
                $formModifier($event->getForm()->getParent(), $university);
            }
        );
        
        $builder->add('degreeLevel', 'entity', array(
            'class' => 'GraduallyUtilBundle:DegreeLevel',
        ));

        $builder->add('result');
        $builder->add('yearAttained'); 
        $builder->add('saveAndAdd', 'submit', array('label' => 'Save and Add'));
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Gradually\GraduateBundle\Entity\Qualification'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gradually_graduatebundle_qualification';
    }
}
