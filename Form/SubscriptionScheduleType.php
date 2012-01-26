<?php

namespace Gpupo\CamelSpiderBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class SubscriptionScheduleType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('time_schedule', 'time', array('required'=>false, 'label'=>'Horário'))
            ->add('sun', 'checkbox', array('required'=>false))
            ->add('mon', 'checkbox', array('required'=>false))
            ->add('tue', 'checkbox', array('required'=>false))
            ->add('wed', 'checkbox', array('required'=>false))
            ->add('thu', 'checkbox', array('required'=>false))
            ->add('fri', 'checkbox', array('required'=>false))
            ->add('sat', 'checkbox', array('required'=>false))
            ->add('is_active', 'checkbox', array('required'=>false, 'label'=>'Ativo'))
            ->add('delete', 'checkbox', array(
                'required'=>false,
                'label'=>'EXCLUIR',
                'attr'=> array(
                    'class' => 'embedded_delete'
                )
             ))
//            ->add('subscription')
        ;
    }

    public function getName()
    {
        return 'subscriptionscheduletype';
    }

    public function getDefaultOptions(array $options){
        return array('data_class' => 'Gpupo\CamelSpiderBundle\Entity\SubscriptionSchedule');
    }
}
