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
            ->add('uri')
            ->add('uri_login')
            ->add('uri_password')
            ->add('filters')
            ->add('created_by')
            ->add('created_at')
            ->add('updated_by')
            ->add('updated_at')
        ;
    }

    public function getName()
    {
        return 'gpupo_camelspiderbundle_subscriptiontype';
    }
}
