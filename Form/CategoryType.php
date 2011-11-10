<?php

namespace Gpupo\CamelSpiderBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Gpupo\CamelSpiderBundle\Entity\CategoryRepository;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('parent', 'entity', array(
                                'class' => 'Gpupo\\CamelSpiderBundle\\Entity\\Category',
                                'query_builder' => function(CategoryRepository $er) {
                                    return $er->createQueryBuilder('c')
                                               ->orderBy('c.lft', 'ASC');
                                },
                                'required' => true,
                                ))
        ;
    }

    public function getName()
    {
        return 'categorytype';
    }
}
