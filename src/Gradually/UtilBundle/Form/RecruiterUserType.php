<?php

namespace Gradually\UtilBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RecruiterUserType extends UserType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
            ->add('companyName', 'text')
            ->add('email', 'email')
            ->add('postingCredits', 'choice', array(
                'choices' => array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', 'n' => 'n'),
                'expanded' => true
            ))
            ->add('premiumCredits', 'choice', array(
                'choices' => array('0' => '0', '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', 'n' => 'n'),
                'expanded' => true
            ))
            ->add('searchCredits', 'choice', array(
                'choices' => array('0' => '0', '1' => '1'),
                'expanded' => true
            ))
            ->add('save', 'submit', array(
                'label' => 'Post Job'
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Gradually\UtilBundle\Entity\RecruiterUser'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gradually_utilbundle_recruiteruser';
    }
}