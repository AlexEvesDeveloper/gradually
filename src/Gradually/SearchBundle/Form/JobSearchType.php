<?php

namespace Gradually\SearchBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class JobSearchType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('keywords')
            ->add('salaryFrom')
            ->add('salaryTo')
            ->add('recruiter', 'entity', array(
                'class' => 'Gradually\UserBundle\Entity\RecruiterUser',
                'multiple' => false,
                'expanded' => false,
                'empty_value' => 'All',
                'property' => 'companyName',
                'required' => false,
                'query_builder' => function(EntityRepository $er){
                    return $er->createQueryBuilder('user')->orderBy('user.companyName', 'ASC');
                }
            ))
            ->add('save', 'submit', array('label' => 'Search'));
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Gradually\SearchBundle\Entity\JobSearch'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gradually_searchbundle_jobsearch';
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
            array('field' => 'recruiter', 'property' => 'id', 'owningEntity' => 'recruiter', 'isEntity' => true),
            array('field' => 'salaryFrom', 'property' => 'salaryFrom', 'owningEntity' => 'job', 'isEntity' => false),
            array('field' => 'salaryTo', 'property' => 'salaryTo', 'owningEntity' => 'job', 'isEntity' => false)

        );
    }
}
