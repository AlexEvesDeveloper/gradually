<?php

namespace Gradually\UtilBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ApplicationType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('coverNote', 'textarea')
            ->add('save', 'submit', array('label' => 'Submit Application'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Gradually\UtilBundle\Entity\Application'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gradually_utilbundle_application';
    }
}
