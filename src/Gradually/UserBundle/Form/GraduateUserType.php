<?php

namespace Gradually\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class GraduateUserType extends UserType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
            ->add('firstName')
            ->add('lastName')
            ->add('submit', 'submit', array('label' => 'Get started'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Gradually\UserBundle\Entity\GraduateUser'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gradually_userbundle_graduateuser';
    }
}
