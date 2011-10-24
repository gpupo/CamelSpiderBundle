<?php

namespace Gpupo\CamelSpiderBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class NewsType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('uri')
            ->add('slug')
            ->add('date', 'date', array('widget'=>'single_text'))
            ->add('annotation')
            ->add('content')
            ->add('created_by')
            ->add('created_at')
            ->add('updated_by')
            ->add('updated_at')
            ->add('subscription')
            ->add('rawnews')
            ->add('tags')
        ;
    }

    public function getName()
    {
        return 'gpupo_camelspiderbundle_newstype';
    }
}
