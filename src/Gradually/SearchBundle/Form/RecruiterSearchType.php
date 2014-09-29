<?php

namespace Gradually\SearchBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class RecruiterSearchType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('recruiter', 'entity', array(
	    	    'class' => 'Gradually\UserBundle\Entity\RecruiterUser',
		        'multiple' => false,
		        'expanded' => false,
		        'empty_value' => 'All',
		        'property' => 'companyName',
		        'required' => false,
		        'query_builder' => function(EntityRepository $er){
			        return $er->createQueryBuilder('recruiter')->orderBy('recruiter.companyName', 'ASC');
		        },
	    ))
            ->add('save', 'submit', array('label' => 'Search'));
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Gradually\SearchBundle\Entity\RecruiterSearch'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gradually_searchbundle_recruitersearch';
    }
}
