<?php

namespace Gpupo\CamelSpiderBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class RawNewsType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('uri')
            ->add('date')
            ->add('rawdata')
            ->add('created_by')
            ->add('created_at')
            ->add('updated_by')
            ->add('updated_at')
            ->add('subscription')
        ;
    }

    public function getName()
    {
        return 'gpupo_camelspiderbundle_rawnewstype';
    }
}
