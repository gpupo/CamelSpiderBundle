<?php

namespace Gpupo\CamelSpiderBundle\Generator;

use Coregen\AdminGeneratorBundle\Generator\Generator;

class NewsSource extends Generator
{
    protected function configure()
    {
        $actions = array();

        $fields  = array(
            'id'           => array('label' => 'ID'),
            'name'         => array('label' => 'Nome', 'size' => 'xlarge'),
            'uri'          => array('label' => 'URI', 'size' => 'xxlarge', 'help' => 'Full path to the subscription source'),
            'uri_login'    => array('label' => 'URI Login'),
            'uri_password' => array('label' => 'URI Password', 'class' => 'date'),
            'filters'      => array('label' => 'Filtros'),
            'created_by'   => array('label' => 'Criado Por'),
            'created_at'   => array('label' => 'Criado Em', 'date_format' => 'd/m/Y H:i:s'),
            'updated_by'   => array('label' => 'Atualiado Por'),
            'updated_at'   => array('label' => 'Atualizado Em', 'date_format' => 'd/m/Y H:i:s'),
        );

        $list = array(
            'title'           => 'Listing News Source',
            'method'          => 'findAll',
            'count_method'    => 'count',
            'display'         => array(
                                'id',
                                'name',
                                'uri',
                                //'uri_login',
                                //'uri_password',
                                'filters',
                                'created_by',
                                'created_at',
                                //'updated_by',
                                //'updated_at',
                                ),
            # grid or stacked, default grid
            'layout'          => 'grid',
            'stackedTemplate' => '<h3>{{ record.name  }}</h3>' .
                                 '<p class="details_fixed">URI: <strong>{{ record.uri }}</strong></p>',
            'sort'            => array(),
            'max_per_page'    => 10,
            'object_actions'  => array(),
            'batch_actions'   => array(),
        );

        $form = array(
            'type'   => "Gpupo\CamelSpiderBundle\Form\NewsSourceType",
        );

        $edit = array(
            'title'   => "Editing NewsSource",
            'display'         => array(
                                //'id',
                                'name',
                                'uri',
                                'uri_login',
                                'uri_password',
                                'filters',
                                ),
            'actions' => array(),
        );

        $new = array(
            'title'   => "New NewsSource",
            'display'         => array(
                                //'id',
                                'name',
                                'uri',
                                'uri_login',
                                'uri_password',
                                'filters',
                                ),
            'actions' => array(),
        );

        $show = array(
            'title'   => "Viewing NewsSource",
        );

        $filter = array(
            'display' => array(),
            'actions' => array(),
        );
        $this
            ->setClass('\Gpupo\CamelSpiderBundle\Entity\NewsSource')
            ->setModel('GpupoCamelSpiderBundle:NewsSource')
            ->setCoreTheme('CoregenThemeBootstrapBundle')
            ->setLayoutTheme('FunparAdminBundle')
            ->setRoute('newssource')
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
