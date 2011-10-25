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
            ->add('auth_info')
            ->add('uri_target')
            ->add('filters_contain', 'textarea')
            ->add('filters_not_contain', 'textarea')
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
