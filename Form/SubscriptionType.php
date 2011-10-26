<?php

namespace Gpupo\CamelSpiderBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class SubscriptionType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('source_type', 'choice', array('choices'=>array('html'=>'HTML','rss'=>'RSS','atom'=>'ATOM')))
            ->add('source_domain')
            ->add('auth_info', 'text', array('required'=>false))
            ->add('uri_target')
            ->add('max_depth','choice', array('choices'=>array(1=>1,2=>2,3=>3,4=>4,5=>5,6=>6,7=>7,8=>8,9=>9,10=>10)))
            ->add('filters_contain', 'textarea', array('required'=>false))
            ->add('filters_not_contain', 'textarea', array('required'=>false))
            ->add('created_by')
            ->add('created_at')
            ->add('updated_by')
            ->add('updated_at')
            ->add('schedules', 'collection', array(
                'type' =>  new SubscriptionScheduleType(),
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'by_reference' => false,
            ))
        ;
    }

    public function getName()
    {
        return 'subscriptiontype';
    }

    public function getDefaultOptions(array $options){
        return array('data_class' => 'Gpupo\CamelSpiderBundle\Entity\Subscription');
    }

}
