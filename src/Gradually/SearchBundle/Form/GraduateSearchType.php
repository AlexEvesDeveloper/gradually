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
	       
            ->add('yearAttained', 'text', array(
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

    /**
     * Return an array that is used by the SearchHandler.
     * Each item represents a filter that was placed on the search.
     * There should be an entry for each field defined above.
	 * 'field' => name of field declared above
	 * 'property' => the db column (entity property) against which the input will be compared against
     * 'owningEntity' => the entity to which the property belongs
     * 'isEntity' => is the field an entity?
     *
     * @return array
     */
    public static function getFields()
    {
    	return array(
    		array('field' => 'university', 'property' => 'id', 'owningEntity' => 'university', 'isEntity' => true),
    		array('field' => 'degree', 'property' => 'id', 'owningEntity' => 'degree', 'isEntity' => true),
    		array('field' => 'yearAttained', 'property' => 'yearAttained', 'owningEntity' => 'qualification', 'isEntity' => false),
    		array('field' => 'result', 'property' => 'result', 'owningEntity' => 'qualification', 'isEntity' => false)
    	);
    }
}
