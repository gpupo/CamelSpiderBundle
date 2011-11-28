<?php

namespace Gpupo\CamelSpiderBundle\Generator;

use Coregen\AdminGeneratorBundle\Generator\Generator;

class Subscription extends Generator
{
    protected function configure()
    {
        $actions = array();

        $fields  = array(
            'id'                  => array('label' => 'ID'),
            'name'                => array('label' => 'Name', 'size' => 'xlarge', 'help' => 'The name of subscription'),
            'format'              => array('label' => 'Format', 'size' => 'medium', 'help' => 'Storing format (HTML or TXT)'),
            'encoding'            => array('label' => 'Encoding', 'size' => 'medium', 'help' => 'Encoding format (UTF8 or ISO)'),
            'category'            => array('label' => 'Category', 'size' => 'medium', 'help' => 'Default category to register on news'),
            'source_type'         => array('label' => 'Type', 'size' => 'small', 'help' => 'The type of subscription - HTML, RSS or ATOM'),
            'source_domain'       => array('label' => 'Domain', 'size' => 'xxlarge', 'help' => 'Domains to search for, comma separated'),
            'href'                => array('label' => 'Href', 'size' => 'xxlarge', 'help' => 'Full path to the subscription source'),
            'auth_info'           => array('label' => 'Auth Info', 'size' => 'xxlarge', 'help' => 'Auth string to the subscription'),
            'uri_target'          => array('label' => 'URL Login', 'size' => 'xxlarge', 'help' => 'Full path to the subscription auth target'),
            'max_depth'           => array('label' => 'Max Depth', 'size' => 'small', 'help' => 'Levels of links to follow'),
            'filters_contain'     => array('label' => 'Filters CONTAIN', 'help' => 'Words the news must contain - one per line'),
            'filters_not_contain' => array('label' => 'Filters NOT CONTAIN', 'help' => 'Words the news must NOT contain - one per line'),
            'created_by'          => array('label' => 'Created By'),
            'created_at'          => array('label' => 'Created At', 'date_format' => 'd/m/Y H:i:s'),
            'updated_by'          => array('label' => 'Updated By'),
            'updated_at'          => array('label' => 'Updated At', 'date_format' => 'd/m/Y H:i:s'),
            'is_active'           => array('label' => 'Is Active', 'size' => 'small'),
            'schedules'           => array('label' => 'Schedules', 'class' => 'schedule_list', 'help' => 'Schedules to check for updates'),
            'stats'               => array('label' => 'Stats', 'list_partial' => 'GpupoCamelSpiderBundle:Subscription:stats.html.twig'),
        );

        $list = array(
            'title'           => 'Listing Subscriptions',
            'query_builder'   => null,
            'display'         => array(
                                'id',
                                'name',
                                'created_by',
                                //'source_type',
                                //'is_active',
                                'stats',
                                //'is_active',t
                                //'source_domain',
                                //'uri_login',
                                //'uri_password',
                                //'filters',
                                //'created_by',
                                //'created_at',
                                //'updated_by',
                                //'updated_at',
                                ),
            # grid or stacked, default grid
            'layout'          => 'grid',
            'stackedTemplate' => '<h3>{{ record.name  }}</h3>' .
                                 '<p class="details_fixed">URI: <strong>{{ record.uri }}</strong></p>',
            'sort'            => array(),
            'max_per_page'    => 30,
            'object_actions'  => array(),
            'batch_actions'   => array(),
        );

        $form = array(
            'type'   => "Gpupo\CamelSpiderBundle\Form\SubscriptionType",
        );

        $edit = array(
            'title'   => "Editing Subscription",
            'display'         => array(
                                //'id',
                                'name',
                                'format',
                                'encoding',
                                'category',
                                'source_type',
                                'source_domain',
                                'href',
                                'auth_info',
                                'uri_target',
                                'max_depth',
                                'filters_contain',
                                'filters_not_contain',
                                'is_active',
                                'schedules',
                                ),
            'actions' => array(),
        );

        $new = array(
            'title'   => "New Subscription",
            'display'         => array(
                                //'id',
                                'name',
                                'format',
                                'encoding',
                                'category',
                                'category',
                                'source_type',
                                'source_domain',
                                'href',
                                'auth_info',
                                'uri_target',
                                'max_depth',
                                'filters_contain',
                                'filters_not_contain',
                                'is_active',
                                'schedules',
                                ),
            'actions' => array(
                'save'         => true,
                'save_and_add' => false,
                'back_to_list' => true,
            ),
        );

        $show = array(
            'title'   => "Viewing Subscription",
            'display'         => array(
                                //'id',
                                'name',
                                'format',
                                'encoding',
                                'category',
                                'source_type',
                                'source_domain',
                                'href',
                                'auth_info',
                                'uri_target',
                                'filters_contain',
                                'filters_not_contain',
                                'is_active',
                                'schedules',
                                'created_by',
                                'created_at',
                                'updated_by',
                                'updated_at',
                                ),
        );

        $filter = array(
            'display' => array(),
            'actions' => array(),
        );
        $this
            ->setClass('\Gpupo\CamelSpiderBundle\Entity\Subscription')
            ->setModel('GpupoCamelSpiderBundle:Subscription')
            ->setCoreTheme('CoregenThemeBootstrapBundle')
            ->setLayoutTheme('FunparAdminBundle')
            ->setRoute('subscription')
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
