<?php

namespace Gradually\SearchBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class GraduateSearchType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('university', 'entity', array(
	    	'class' => 'Gradually\UtilBundle\Entity\University'
	    ))
            ->add('degree', 'entity', array(
		'class' => 'Gradually\UtilBundle\Entity\Degree'
	    ))
	    ->add('save', 'submit', array('label' => 'Search'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Gradually\SearchBundle\Entity\GraduateSearch'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gradually_searchbundle_graduatesearch';
    }
}
