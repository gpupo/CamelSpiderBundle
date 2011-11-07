<?php

namespace Gpupo\CamelSpiderBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Gpupo\CamelSpiderBundle\Entity\CategoryRepository;

class NewsType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('category', 'entity', array(
                                'class' => 'Gpupo\\CamelSpiderBundle\\Entity\\Category',
                                'query_builder' => function(CategoryRepository $er) {
                                    return $er->createQueryBuilder('c')
                                        ->orderBy('c.name', 'ASC');
                                },))
            ->add('uri')
            ->add('slug', 'text', array('required'=>false))
            ->add('date', 'date', array('widget'=>'single_text'))
            ->add('annotation', 'textarea', array(
                'required'=>false,
                'attr' => array('style' => 'height:200px;')
                ))
            ->add('content')
            ->add('created_by')
            ->add('created_at')
            ->add('updated_by')
            ->add('updated_at')
            ->add('subscription')
            ->add('rawnews')
            ->add('tags')
            ->add('moderation', 'choice', array('choices'=>array('PENDING'=>'PENDING','APROVED'=>'APROVED','REJECTED'=>'REJECTED')))
        ;
    }

    public function getName()
    {
        return 'gpupo_camelspiderbundle_newstype';
    }
}
