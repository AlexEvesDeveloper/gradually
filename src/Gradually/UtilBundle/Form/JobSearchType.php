<?php

namespace Gradually\UtilBundle\Form;

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
            ->add('salaryFrom', 'choice', array(
                'choices' => $this->getSalaryChoices(),
                'empty_value' => 'No minimum',
		        'required' => false,
            ))
            ->add('salaryTo', 'choice', array(
                'choices' => $this->getSalaryChoices(),
                'empty_value' => 'No maximum',
		        'required' => false,
            ))
            ->add('recruiter', 'entity', array(
                'class' => 'Gradually\UtilBundle\Entity\RecruiterUser',
                'multiple' => false,
                'expanded' => false,
                'empty_value' => 'All',
                'property' => 'companyName',
                'required' => false,
                'query_builder' => function(EntityRepository $er){
                    return $er->createQueryBuilder('user')->orderBy('user.companyName', 'ASC');
                }
            ))
	        ->add('locationString', 'text', array(
                'required' => false
            ))
	        ->add('distance')
            ->add('save', 'submit', array('label' => 'Search'));
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Gradually\UtilBundle\Entity\JobSearch'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gradually_utilbundle_jobsearch';
    }

    protected function getSalaryChoices()
    {
        return array(
            '10000' => '10,000',
            '15000' => '15,000',
            '20000' => '20,000',
            '25000' => '25,000',
            '30000' => '30,000',
            '35000' => '35,000',
            '40000' => '40,000',
            '45000' => '45,000',
            '50000' => '50,000',
            '55000' => '55,000',
            '60000' => '60,000',
            '65000' => '65,000',
            '70000' => '70,000',
            '75000' => '75,000',
            '80000' => '80,000',
            '85000' => '85,000',
            '90000' => '90,000',
            '95000' => '95,000',
            '100000' => '100,000'
        );
    }
}
