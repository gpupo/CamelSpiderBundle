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
            'parent'       => array('label' => 'Parent'),
            'nameIndented' => array('label' => 'Name'),
        );

        $list = array(
            'title'           => 'Listing Categories',
            'query_builder'   => 'findForList',
            'display'         => array(
                                //'id',
                                'nameIndented',
                                ),
            # grid or stacked, default grid
            'layout'          => 'grid',
            'stackedTemplate' => '<h3>{{ record.name  }}</h3>' .
                                 '<p class="details_fixed">URI: <strong>{{ record.uri }}</strong></p>',
            'sort'            => array('lft'=> 'ASC'),
            'max_per_page'    => 200,
            'object_actions'  => array(),
            'batch_actions'   => array(),
        );

        $form = array(
            'type'   => "Gpupo\CamelSpiderBundle\Form\CategoryType",
        );

        $edit = array(
            'title'   => "Editing Category",
            'display' => array(
                //'id',
                'name',
                'parent',
                ),
            'actions' => array(),
        );

        $new = array(
            'title'   => "New Category",
            'display' => array(
                //'id',
                'name',
                'parent',
                ),
            'actions' => array(
                'save'         => true,
                'save_and_add' => false,
                'back_to_list' => true,
            ),
        );

        $show = array(
            'title'   => "Viewing Category",
            'display' => array(
                //'id',
                'name',
                'parent',
                ),
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
