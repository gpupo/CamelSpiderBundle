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
                                            ->where('c.parent IS NOT NULL')
                                            ->add('orderBy', 'c.lft ASC');
                                },))
            ->add('uri')
            ->add('slug', 'text', array('required'=>false))
            ->add('date', 'date', array('widget'=>'single_text'))
            ->add('content')
            ->add('created_by')
            ->add('created_at')
            ->add('updated_by')
            ->add('updated_at')
            ->add('subscription', 'entity', array(
                             'class' => 'Gpupo\\CamelSpiderBundle\\Entity\\Subscription',
                             'query_builder' => function(
                                    \Doctrine\ORM\EntityRepository $er
                                ) {
                                return $er->createQueryBuilder('a')
                                    ->add('orderBy', 'a.name ASC');
                             }))
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
