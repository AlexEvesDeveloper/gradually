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
        $builder->add('university', 'entity', array(
            'class' => 'GraduallyUtilBundle:University',
        ));

        $builder->add('degree', 'entity', array(
            'class' => 'GraduallyUtilBundle:Degree',
        ));
       
        $builder->add('degreeLevel', 'entity', array(
            'class' => 'GraduallyUtilBundle:DegreeLevel',
        ));

        $builder->add('result', 'entity', array(
            'class' => 'GraduallyUtilBundle:DegreeResult',
            'property' => 'name'
        ));

        $builder->add('yearAttained'); 
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
