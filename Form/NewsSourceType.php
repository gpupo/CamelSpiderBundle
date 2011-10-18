<?php

namespace Gpupo\CamelSpiderBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class NewsSourceType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('name', 'text', array('required'=>true))
            ->add('uri', 'text', array('required'=>true))
            ->add('uri_login', 'text', array('required'=>false))
            ->add('uri_password', 'text', array('required'=>false, 'attr'=> array('class'=>'date')))
            ->add('filters', 'textarea', array('required'=>false))
            ->add('created_by', 'text', array('required'=>false))
            ->add('created_at', 'datetime',array('required'=>false))
            ->add('updated_by', 'text', array('required'=>false))
            ->add('updated_at', 'datetime', array('required'=>false))
        ;
    }

    public function getName()
    {
        return 'gpupo_camelspiderbundle_newssourcetype';
    }
}
