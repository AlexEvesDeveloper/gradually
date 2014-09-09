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
}
