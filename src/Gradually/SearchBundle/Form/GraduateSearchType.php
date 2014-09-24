<?php

namespace Gradually\SearchBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

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
	    	    'class' => 'Gradually\UtilBundle\Entity\University',
		        'multiple' => false,
		        'expanded' => false,
		        'empty_value' => 'All',
		        'property' => 'name',
		        'required' => false,
		        'query_builder' => function(EntityRepository $er){
			        return $er->createQueryBuilder('university')->orderBy('university.name', 'ASC');
		        },
	    ))
            ->add('degree', 'entity', array(
		        'class' => 'Gradually\UtilBundle\Entity\Degree',
		        'multiple' => false,
		        'expanded' => false,
		        'empty_value' => 'All',
		        'property' => 'title',
		        'required' => false,
		        'query_builder' => function(EntityRepository $er){
			        return $er->createQueryBuilder('degree')->orderBy('degree.title', 'ASC');
		        },
	    ))
	       
            ->add('yearFrom', 'text', array(
		        'required' => false
	        ))

            ->add('yearTo', 'text', array(
                'required' => false
            ))

	        ->add('result', 'text', array(
		        'required' => false
	        ))
	    
            ->add('save', 'submit', array('label' => 'Search'));
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
