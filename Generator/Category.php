<?php

namespace Gpupo\CamelSpiderBundle\Generator;

use Coregen\AdminGeneratorBundle\Generator\Generator;

class Category extends Generator
{
    protected function configure()
    {
        $actions = array();

        $fields  = array(
            'id'           => array('label' => 'ID'),
            'name'         => array('label' => 'Name', 'size' => 'medium', 'help' => 'Category name'),
        );

        $list = array(
            'title'           => 'Listing Categories',
            'method'          => 'findAll',
            'count_method'    => 'count',
            'display'         => array(
                                'id',
                                'name',
                                ),
            # grid or stacked, default grid
            'layout'          => 'grid',
            'stackedTemplate' => '<h3>{{ record.name  }}</h3>' .
                                 '<p class="details_fixed">URI: <strong>{{ record.uri }}</strong></p>',
            'sort'            => array(),
            'max_per_page'    => 20,
            'object_actions'  => array(),
            'batch_actions'   => array(),
        );

        $form = array(
            'type'   => "Gpupo\CamelSpiderBundle\Form\CategoryType",
        );

        $edit = array(
            'title'   => "Editing Category",
            'display'         => array(
                                //'id',
                                'name',
                                ),
            'actions' => array(),
        );

        $new = array(
            'title'   => "New News",
            'display'         => array(
                                //'id',
                                'name',
                                ),
            'actions' => array(),
        );

        $show = array(
            'title'   => "Viewing Category",
        );

        $filter = array(
            'display' => array(),
            'actions' => array(),
        );
        $this
            ->setClass('\Gpupo\CamelSpiderBundle\Entity\Category')
            ->setModel('GpupoCamelSpiderBundle:Category')
            ->setCoreTheme('CoregenThemeBootstrapBundle')
            ->setLayoutTheme('FunparAdminBundle')
            ->setRoute('category')
            ->setActions($actions)
            ->setList($list)
            ->setFields($fields)
            ->setForm($form)
            ->setEdit($edit)
            ->setNew($new)
            ->setShow($show)
            ->setFilter($filter)
            ;

    }
}
